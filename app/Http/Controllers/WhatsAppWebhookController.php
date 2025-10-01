<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AIController;
use App\Models\Client;
use App\Models\WhatsAppAccount;
use App\Models\WhatsAppBusinessAccount;
use App\Models\WhatsAppConversation;
use App\Models\WhatsappMessage;
use App\Models\WhatsAppMessageTemplate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WhatsAppWebhookController extends Controller
{
    protected $baseUrl = 'https://graph.facebook.com/v23.0/';


    public function handleIncoming(Request $request)
    {
        
        file_put_contents(
            storage_path('logs/whatsapp-webhook.log'),
            '[' . now() . '] ' . $request->getContent() . PHP_EOL,
            FILE_APPEND
        );

        $payload = $request->all();

        if (isset($payload['object']) && $payload['object'] === 'whatsapp_business_account') {
            $entry = $payload['entry'][0] ?? null;

            Log::info('Webhook payload received:', $request->all());
            
            if ($entry) {
                $changes = $entry['changes'][0] ?? null;
                
                if ($changes && $changes['field'] === 'messages') {
                    $value = $changes['value'];
                    
                    if (isset($value['messages'])) {
                        $this->processIncomingMessage($value);
                    }
                    
                    if (isset($value['statuses'])) {
                        $this->processStatusUpdate($value);
                    }
                } elseif ($changes['field'] === 'message_template_status_update') {
                    $value = $changes['value'];

                    Log::info('Template status update received:', $value);

                    WhatsAppMessageTemplate::where('template_id', $value['message_template_id'])
                        ->update([
                            'status' => strtolower($value['event']), 
                            'meta'   => $value
                        ]);
                }
            }
            
            return response('EVENT_RECEIVED', 200);
        }

        return response('Invalid payload', 404);
    }

    private function processIncomingMessage($value)
    {
        Log::info($value);
        $message = $value['messages'][0];
        $from = $message['from'];
        $messageId = $message['id'];
        $timestamp = $message['timestamp'];
        $type = $message['type'];
        $contactName = $value['contacts'][0]['profile']['name'] ?? $from;


        $phoneNumberId = $value['metadata']['phone_number_id'];
        $account = WhatsAppBusinessAccount::where('phone_number_id', $phoneNumberId)->first();

        if (!$account) {
            Log::error("WhatsApp account not found for phone_number_id: " . $phoneNumberId);
            return;
        }

        $contactNumber = $from;
        $conversation = WhatsAppConversation::firstOrCreate(
            [
                'whatsapp_business_account_id' => $account->id,
                'contact_number' => $contactNumber
            ],
            [
                'contact_name' => $contactName 
            ]
        );  


        $client = Client::firstOrCreate(
        [
            'phone1' => $contactNumber,  
        ],
        [
            'id_user'   => $account->user['id'], 
            'name'      => $contactName,
            'id_country'=> $account->user['country_id'] ?? null, 
            'city'      => null,
            'phone2'    => null,
            'address'   => null,
            'seller_note' => null,
        ]
        );

        $messageBody = '';
        $mediaData = [];

        switch ($type) {
            case 'text':
                $messageBody = $message['text']['body'];
                break;
                
            case 'image':
                $messageBody = 'Photo';
                $mediaData = [
                    'id' => $message['image']['id'],
                    'mime_type' => $this->getMimeTypeFromExtension($message['image']['mime_type'] ?? 'image/jpeg')
                ];
                break;
                
            case 'video':
                $messageBody = 'Video';
                $mediaData = [
                    'id' => $message['video']['id'],
                    'mime_type' => $message['video']['mime_type'] ?? 'video/mp4'
                ];
                break;
                
            case 'audio':
                $messageBody = 'Audio message';
                $mediaData = [
                    'id' => $message['audio']['id'],
                    'mime_type' => $message['audio']['mime_type'] ?? 'audio/ogg'
                ];
                break;
                
            case 'document':
                $messageBody = 'Document: ' . ($message['document']['filename'] ?? 'File');
                $mediaData = [
                    'id' => $message['document']['id'],
                    'mime_type' => $message['document']['mime_type'] ?? 'application/octet-stream',
                    'filename' => $message['document']['filename'] ?? 'file'
                ];
                break;
                
            default:
                $messageBody = 'Unsupported message type';
                Log::info("Unhandled message type: {$type}");
                break;
        }

        $quotedMessageId = null;
        if (isset($message['context']) && isset($message['context']['id'])) {
            $quotedMessageId = $message['context']['id'];
        }

        $dbMessage = $conversation->messages()->create([
            'message_id' => $messageId,
            'from' => $from,
            'to' => $account->phone_number,
            'body' => $messageBody,
            'direction' => 'in',
            'status' => 'delivered',
            'read' => false,
            'quoted_message_id' => $quotedMessageId
        ]);

        $unreadCount = $conversation->messages()
        ->where('read', false)
        ->where('direction', 'in')
        ->count();

        $dbMessage->unread_count = $unreadCount;

        if (!empty($mediaData)) {
            $this->downloadAndStoreMedia($account, $mediaData, $dbMessage->id);
        }

        $conversation->touch();

        $this->broadcastNewMessage($account, $conversation, $dbMessage);
    }

    private function processStatusUpdate($value)
    {
        $status = $value['statuses'][0];
        $messageId = $status['id'];
        $statusValue = $status['status'];
        $timestamp = $status['timestamp'];
        $recipientId = $status['recipient_id'];

        Log::info("Message status update - ID: {$messageId}, Status: {$statusValue}");

        $message = WhatsappMessage::where('message_id', $messageId)->first();
        
        if ($message) {
                $errorData = null;
                if ($statusValue === 'failed' && isset($status['errors'])) {
                    $errorData = [
                        'errors' => $status['errors'],
                        'timestamp' => $timestamp,
                        'recipient_id' => $recipientId
                    ];
                    
                    Log::error("Message failed - ID: {$messageId}", $errorData);
                }
                
                $message->update([
                    'status' => $statusValue,
                    'error_data' => $errorData ? json_encode($errorData) : null
                ]);
                
                $this->broadcastMessageStatusUpdate($message);
            }
    }

    private function downloadAndStoreMedia($account, $mediaData, $messageId)
    {
        try {
            $mediaUrlResponse = Http::withToken(decrypt($account->access_token))
                ->get($this->baseUrl . $mediaData['id']);

            if (!$mediaUrlResponse->successful()) {
                Log::error('Failed to get media URL', [
                    'media_id' => $mediaData['id'],
                    'response' => $mediaUrlResponse->body()
                ]);
                return;
            }

            $mediaUrlData = $mediaUrlResponse->json();
            $directMediaUrl = $mediaUrlData['url'] ?? null; 

            if (!$directMediaUrl) {
                Log::error('No URL found in media response', ['response' => $mediaUrlData]);
                return;
            }

            $mediaResponse = Http::withToken(decrypt($account->access_token))
                ->get($directMediaUrl);

            if (!$mediaResponse->successful()) {
                Log::error('Failed to download media from URL', [
                    'url' => $directMediaUrl,
                    'status' => $mediaResponse->status()
                ]);
                return;
            }

            $fileContents = $mediaResponse->body();
            
            $extension = $this->getExtensionFromMimeType($mediaData['mime_type']);
            $filename = 'whatsapp_media/' . Str::uuid() . $extension;

            $storagePath = Storage::disk('public')->put($filename, $fileContents);

            if (!$storagePath) {
                Log::error('Failed to store media file');
                return;
            }

            WhatsappMessage::find($messageId)->media()->create([
                'media_id' => $mediaData['id'],
                'file_path' => $filename, 
                'mime_type' => $mediaData['mime_type'],
                'extension' => ltrim($extension, '.'), 
            ]);

            Log::info('Media downloaded and stored successfully', [
                'filename' => $filename,
                'media_id' => $mediaData['id']
            ]);

        } catch (\Exception $e) {
            Log::error('Media download failed: ' . $e->getMessage());
        }
    }


    private function getMimeTypeFromExtension($mimeType)
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'video/mp4' => 'mp4',
            'audio/ogg' => 'ogg',
            'audio/aac' => 'aac',
        ];
        
        return array_search($mimeType, $map) ?: $mimeType;
    }

    private function getExtensionFromMimeType($mimeType)
    {
        $map = [
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
            'video/mp4' => '.mp4',
            'audio/ogg' => '.ogg',
            'audio/aac' => '.aac',
            'application/pdf' => '.pdf',
        ];
        
        return $map[$mimeType] ?? '.bin';
    }

    private function broadcastNewMessage($account, $conversation, $message)
    {
        $pusher = new \Pusher\Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        $message->load('media');

        $pusher->trigger(
            'whatsapp.'.$account->id,
            'NewMessage',
            [
                'message' => $message,
                'conversation_id' => $conversation->id,
                'contact_number' => $conversation->contact_number,
                'contact_name' => $conversation->contact_name
            ]
        );
    }

    private function broadcastMessageStatusUpdate($message)
    {
        $pusher = new \Pusher\Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        $pusher->trigger(
            'whatsapp.'.$message->conversation->whatsapp_business_account_id,
            'MessageUpdate',
            [
                'id' => $message->id,
                'status' => $message->status,
                'error_data' => $message->error_data,
                'conversation_id' => $message->whats_app_conversation_id
            ]
        );
    }

}