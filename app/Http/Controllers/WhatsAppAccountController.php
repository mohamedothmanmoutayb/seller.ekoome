<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Services\WhatsAppService;
use App\Models\WhatsappBusinessAccount;
use App\Models\WhatsAppConversation;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Pusher\Pusher;

class WhatsAppAccountController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index()
    {
        $accounts = WhatsappBusinessAccount::where('user_id', auth()->id())->get();
        $agents = User::whereHas('rol', function($query) {
            $query->where('name', 'Agent confirmation');
        })->get();
        $appId = env('WHATSAPP_CLIENT_ID'); 
        $businessId = '921166036103985';
        $redirectUri = URL::route('whatsapp-numbers.callback');
        
        $whatsappOAuthUrl = "https://web.facebook.com/v23.0/dialog/oauth?" . http_build_query([
            'app_id' => $appId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'whatsapp_business_management,business_management',
            'business_id' => $businessId,
            'setup' => 'new',
            'state' => csrf_token(), 
        ]);
        
        return view('backend.plugins.whatsapp-numbers', compact('accounts', 'agents','whatsappOAuthUrl'));
    }

    public function handleCallback(Request $request)
{
    if ($request->has('error')) {
        // Handle error
        return redirect()->back()->with('error', $request->error_description);
    }

    $code = $request->code;
    
    $response = Http::post('https://graph.facebook.com/v19.0/oauth/access_token', [
        'client_id' => env('WHATSAPP_CLIENT_ID'),
        'client_secret' => env('WHATSAPP_CLIENT_SECRET'),
        'redirect_uri' => URL::route('whatsapp-numbers.callback'),
        'code' => $code,
    ]);
    dd($response->json());
    $accessToken = $response->json()['access_token'];
    dd($accessToken);
    // Store the access token securely
    // You can now use this token to register phone numbers
    
    return redirect()->route('whatsapp.numbers')->with('success', 'WhatsApp connected successfully!');
}

    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20|unique:whatsapp_business_accounts',
            'instance_id' => 'required|string',
            'token' => 'required|string',
            'agents' => 'sometimes|array'
        ]);
    
        $webhookToken = Str::random(40);
        $webhookUrl = route('whatsapp-numbers.webhook', $webhookToken);

        $account = WhatsAppBusinessAccount::create([
            'user_id' => auth()->id(),
            'phone_number' => $request->phone_number,
            'instance_id' => $request->instance_id,
            'token' => encrypt($request->token),
            'webhook_token' => $webhookToken,
            'status' => 'active'
        ]);
    
        if ($request->has('agents')) {
            $account->agents()->sync($request->agents);
        }
    
        $alertHtml = '
        <div class="alert alert-success mt-3">
            <h4 class="alert-heading">Webhook URL</h4>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="webhook-url" value="'.$webhookUrl.'" readonly>
                <button class="btn btn-outline-secondary" type="button" onclick="copyWebhookUrl()">
                    <i class="ti ti-copy"></i> Copy
                </button>
            </div>
            <p class="mb-0">Please paste this URL in your UltraMsg webhook settings</p>
        </div>';
    
        return response()->json([
            'success' => true,
            'message' => 'Account connected successfully!',
            'webhook_url' => $webhookUrl,
            'alert_html' => $alertHtml
        ]);
    }

    public function destroy(WhatsAppBusinessAccount $account)
    {
        $account->delete();
        return response()->json(['success' => true]);
    }

    public function webhook(Request $request, $token)
    {
        RateLimiter::attempt(
            'whatsapp-webhook:'.$token,
            100,
            function() {},
            60
        );

        Log::info('WhatsApp webhook received', ['token' => $token, 'request' => $request->all()]);
    
        $account = WhatsAppBusinessAccount::where('webhook_token', $token)->firstOrFail();
        
        if (empty($request->data) || !is_array($request->data)) {
            Log::error('Invalid webhook structure', ['request' => $request->all()]);
            return response()->json(['status' => 'error', 'message' => 'Invalid data structure'], 400);
        }
    
        $this->processWebhookData($account, $request->all());
        
        return response()->json(['status' => 'success']);
    }

    private function processWebhookData($account, $data)
    {
        $messageData = $data['data'] ?? [];
        $messageType = $data['event_type'] ?? null;
        
        if($messageType === "message_create") {
            $message = WhatsappMessage::where('message_id', $data['id'])->first();
            if ($message) {
                $message->update([
                    'message_id' => $messageData['id']
                ]);
                $this->broadcastMessageUpdate($account, $message);
            } else {
                Log::error('Message not found for create event', ['data' => $data]);
            }
        }
        if ($messageType === 'message_ack') {
            $messageId = $messageData['id'] ?? null;
            $ackStatus = $messageData['ack'] ?? null;

            if (!$messageId || !$ackStatus) {
                Log::error('Missing message ID or ack status', ['data' => $data]);
                return;
            }
            
            if ($messageId && $ackStatus) {
                $statusMap = [
                    'server' => 'delivered',
                    'device' => 'delivered',
                    'read' => 'read',
                    'played' => 'read' 
                ];
                
                if (array_key_exists($ackStatus, $statusMap)) {
                    $message = WhatsappMessage::where('message_id', $messageId)->first();
                    
                    if ($message) {
                        $message->update(['status' => $statusMap[$ackStatus]]);
                        
                        $this->broadcastMessageUpdate($account, $message);
                    }
                }
            }
            return;
        }
        
        if (in_array($messageType, ['message_reaction', 'message_revoke'])) {
            return;
        }
        
        $fromNumber = str_replace('@c.us', '', $messageData['from'] ?? '');
        
        if (!isset($messageData['from']) || !str_ends_with($messageData['from'], '@c.us')) {
            return;
        }
    
        $conversation = WhatsAppConversation::firstOrCreate([
            'whatsapp_business_account_id' => $account->id,
            'contact_number' => $fromNumber
        ], [
            'contact_name' => $messageData['pushname'] ?? 'Unknown'
        ]);
    
        $messageAttributes = [
            'message_id' => $messageData['id'] ?? Str::random(20),
            'from' => $fromNumber,
            'to' => str_replace('@c.us', '', $messageData['to'] ?? ''),
            'direction' => 'in',
            'status' => 'received',
            'read' => false,
            'body' => $this->getMessageBody($messageData),
        ];
    
        if (!empty($messageData['quotedMsg'])) {
            $quotedMessage = WhatsappMessage::where('message_id', $messageData['quotedMsg']['id'])->first();
            if ($quotedMessage) {
                $messageAttributes['quoted_message_id'] = $quotedMessage->id;
            }
            $messageAttributes['body'] = $this->formatReplyMessage($messageData);
        }
    
        $message = $conversation->messages()->create($messageAttributes);
    
        if (!empty($messageData['media'])) {
            $this->processMedia($account, $message, $messageData['media']);
        }
    
        $this->broadcastNewMessage($account, $conversation, $message);
    }
    
    private function getMessageBody($messageData)
    {
        switch ($messageData['type'] ?? 'chat') {
            case 'image':
                return 'Photo';
            case 'video':
                return 'Video';
            case 'audio':
                return 'Audio message';
            case 'document':
                return 'Document';
            default:
                return $messageData['body'] ?? null;
        }
    }

    private function broadcastNewMessage($account, $conversation, $message)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        $pusher->trigger(
            'whatsapp.'.$account->id,
            'NewMessage',
            [
                'message' => $message->load('media'),
                'conversation_id' => $conversation->id,
                'contact_name' => $conversation->contact_name
            ]
        );
    }

    private function broadcastMessageUpdate($account, $message)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
    
        $pusher->trigger(
            'whatsapp.'.$account->id,
            'MessageUpdate',
            [
                'message_id' => $message->message_id,
                'id' => $message->id,
                'status' => $message->status,
                'conversation_id' => $message->whats_app_conversation_id
            ]
        );
    }


    public function sendMessage(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'conversation_id' => 'required|exists:whatsapp_conversations,id',
            'account_id' => 'required|exists:whatsapp_business_accounts,id',
            'message' => 'required_without_all:media,audio',
            'media' => 'sometimes|file',
            'audio' => 'sometimes|file|mimes:mp3,aac,ogg'
        ]);

    
        $account = WhatsAppBusinessAccount::findOrFail($request->account_id);
        $conversation = WhatsAppConversation::findOrFail($request->conversation_id);
    
        $mediaPath = null;
        $messageBody = $request->message;
    
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('whatsapp_media', 'public');
        } elseif ($request->hasFile('audio')) {
            $mediaPath = $request->file('audio')->store('whatsapp_media', 'public');
        }

        
        $response = $this->whatsappService->sendMessage(
            $account->instance_id,
            decrypt($account->token),
            $conversation->contact_number.'@c.us',
            $messageBody,
            $mediaPath ? Storage::url($mediaPath) : null
        );

        if ($request->hasFile('audio')) {
            $body = 'Audio message';
        } elseif ($request->hasFile('media')) {
            $mime = $request->file('media')->getMimeType();
        
            if (str_starts_with($mime, 'image/')) {
                $body = 'Photo';
            } elseif ($mime === 'application/pdf') {
                $body = 'PDF file';
            } elseif (str_starts_with($mime, 'video/')) {
                $body = 'Video';
            } elseif (str_starts_with($mime, 'application/')) {
                $body = 'Document';
            } else {
                $body = 'Attached file';
            }
        } else {
            $body = $messageBody;
        }
        
    
        $message = $conversation->messages()->create([
            'message_id' => $response['id'] ?? Str::random(20),
            'from' => $account->phone_number,
            'to' => $conversation->contact_number,
            'body' => $body,
            'direction' => 'out',
            'status' => 'sent',
            'read' => true
        ]);

        $mimeType = $request->hasFile('audio') ? 'audio/mp3' : 
                    ($request->file('media') ? $request->file('media')->getMimeType() : null);

        $extension = $this->getExtensionFromMimeType($mimeType);
    
        if ($mediaPath) {
            $message->media()->create([
                'media_id' => Str::random(20),
                'file_path' => '/public/storage/' . $mediaPath,
                'mime_type' => $mimeType,
                'extension' => $extension,
            ]);
        }
    
        $this->broadcastNewMessage($account, $conversation, $message);
    
        return response()->json(['success' => true]);
    }

    
    private function processMedia($account, $message, $mediaData)
    {
        try {
            $mediaContent = file_get_contents($mediaData);
            if ($mediaContent === false) {
                throw new \Exception('Failed to download the media.');
            }
    
            $mimeType = $this->getMimeTypeFromContent($mediaContent);
            $extension = $this->getExtensionFromMimeType($mimeType);
            
            $filename = uniqid('media_', true) . '.' . $extension;

            $fullPath = storage_path('app/public/whatsapp_media/' . $filename);

            $filePath = '/public/storage/whatsapp_media/' . $filename;

            file_put_contents($fullPath, $mediaContent);
    
            $message->media()->create([
                'media_id' => Str::random(20),
                'mime_type' => $mimeType,
                'extension' => $extension,
                'file_path' => $filePath,
                'caption' =>  null
            ]);
    
        } catch (\Exception $e) {
            Log::error('Media download failed: ' . $e->getMessage());
        }
    }
    
    private function getMimeTypeFromContent($content)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($content);
    
        return $mimeType;
    }

    
    private function getExtensionFromMimeType($mimeType)
    {
        $mimeMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'video/mp4' => 'mp4',
            'video/quicktime' => 'mov',
            'audio/mpeg' => 'mp3',
            'audio/ogg' => 'ogg',
            'audio/wav' => 'wav',
        ];

        return $mimeMap[$mimeType] ?? 'bin'; 
    }
    

    public function importBackup(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:whatsapp_business_accounts,id',
            'backup_file' => 'required|file|mimes:zip,json'
        ]);

        $backup = $this->whatsappService->processBackup(
            $request->file('backup_file'),
            auth()->user()
        );

        return response()->json([
            'message' => 'Backup imported successfully',
            'stats' => $backup
        ]);
    }
}
