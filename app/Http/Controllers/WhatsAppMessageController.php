<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppRegisteredNumber;
use App\Services\WhatsAppCloudApiService;
use Illuminate\Http\Request;

class WhatsAppMessageController extends Controller
{
    protected $whatsAppService;

    public function __construct()
    {
        $this->whatsAppService = new WhatsAppCloudApiService(config('services.whatsapp.cloud_api_token'));
    }

    /**
     * Send a text message
     */
    public function sendText(Request $request, $numberId)
    {
        $registeredNumber = WhatsAppRegisteredNumber::findOrFail($numberId);
        
        $validated = $request->validate([
            'to' => 'required|string',
            'message' => 'required|string',
            'preview_url' => 'nullable|boolean'
        ]);

        $this->whatsAppService
            ->setPhoneNumberId($registeredNumber->phone_number_id);
            
        try {
            $response = $this->whatsAppService->sendTextMessage(
                $validated['to'],
                $validated['message'],
                $validated['preview_url'] ?? false
            );
            
            $this->logMessage(
                $registeredNumber->id,
                $validated['to'],
                $validated['message'],
                'text',
                'outbound',
                $response['messages'][0]['id'] ?? null
            );
            
            return response()->json([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send a template message
     */
    public function sendTemplate(Request $request, $numberId)
    {
        $registeredNumber = WhatsAppRegisteredNumber::findOrFail($numberId);
        
        $validated = $request->validate([
            'to' => 'required|string',
            'template_name' => 'required|string',
            'language_code' => 'required|string|size:2',
            'components' => 'nullable|array'
        ]);

        $this->whatsAppService
            ->setPhoneNumberId($registeredNumber->phone_number_id);
            
        try {
            $response = $this->whatsAppService->sendTemplateMessage(
                $validated['to'],
                $validated['template_name'],
                $validated['language_code'],
                $validated['components'] ?? []
            );
            
            $this->logMessage(
                $registeredNumber->id,
                $validated['to'],
                $validated['template_name'],
                'template',
                'outbound',
                $response['messages'][0]['id'] ?? null
            );
            
            return response()->json([
                'success' => true,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log a message in the database
     */
    protected function logMessage($numberId, $to, $content, $contentType, $direction, $messageId = null)
    {
        $registeredNumber = WhatsAppRegisteredNumber::findOrFail($numberId);
        
        $messageLog = new WhatsAppMessageLog([
            'registered_number_id' => $numberId,
            'message_id' => $messageId,
            'direction' => $direction,
            'from' => $direction === 'outbound' ? $registeredNumber->phone_number : $to,
            'to' => $direction === 'outbound' ? $to : $registeredNumber->phone_number,
            'content' => $content,
            'content_type' => $contentType,
            'status' => $direction === 'outbound' ? 'sent' : 'received'
        ]);
        
        $messageLog->save();
        
        return $messageLog;
    }

    /**
     * Webhook for receiving messages
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        
        if ($request->has('hub_challenge')) {
            return response($request->input('hub_challenge'), 200);
        }
        
        if (isset($payload['entry'][0]['changes'][0]['value']['messages'])) {
            $message = $payload['entry'][0]['changes'][0]['value']['messages'][0];
            $phoneNumberId = $payload['entry'][0]['changes'][0]['value']['metadata']['phone_number_id'];
            
            $registeredNumber = WhatsAppRegisteredNumber::where('phone_number_id', $phoneNumberId)->first();
            
            if ($registeredNumber) {
                $from = $message['from'];
                $content = $this->extractMessageContent($message);
                $contentType = $message['type'];
                
                $this->logMessage(
                    $registeredNumber->id,
                    $from,
                    $content,
                    $contentType,
                    'inbound',
                    $message['id']
                );
                
                // Here you can add your business logic to handle the incoming message
                // For example, auto-reply, process commands, etc.
            }
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Extract content from different message types
     */
    protected function extractMessageContent($message)
    {
        switch ($message['type']) {
            case 'text':
                return $message['text']['body'];
            case 'image':
                return $message['image']['caption'] ?? 'Image received';
            case 'video':
                return $message['video']['caption'] ?? 'Video received';
            case 'audio':
                return 'Audio received';
            case 'document':
                return $message['document']['caption'] ?? 'Document received';
            case 'location':
                return 'Location: ' . $message['location']['latitude'] . ', ' . $message['location']['longitude'];
            case 'sticker':
                return 'Sticker received';
            default:
                return json_encode($message);
        }
    }

    /**
     * Get message logs for a number
     */
    public function logs($numberId)
    {
        $logs = \App\Models\WhatsAppMessageLog::where('registered_number_id', $numberId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($logs);
    }
}