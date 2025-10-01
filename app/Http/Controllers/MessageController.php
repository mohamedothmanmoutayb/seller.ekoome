<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsAppAccount;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\RateLimiter;

class MessageController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
        
        // Rate limiting: 10 messages per minute per user
        $this->middleware('throttle:10,1')->only('send');
    }

    public function send(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:whatsapp_accounts,id',
            'to' => 'required|string',
            'message' => 'required_without:media|string|nullable',
            'media' => 'sometimes|file|mimes:jpg,png,mp3,mp4'
        ]);

        $account = WhatsAppAccount::findOrFail($request->account_id);
        $this->authorize('useAccount', $account);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('whatsapp/media');
        }

        $response = $this->whatsappService->sendMessage(
            $account->instance_id,
            decrypt($account->token),
            $request->to,
            $request->message,
            $mediaPath
        );

        $message = $account->messages()->create([
            'message_id' => $response['id'],
            'from' => $account->phone_number,
            'to' => $request->to,
            'body' => $request->message,
            'direction' => 'out',
            'status' => 'sent',
            'timestamp' => now()
        ]);

        return response()->json([
            'message' => 'Message sent',
            'data' => $message
        ]);
    }

    public function getChatHistory(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:whatsapp_accounts,id',
            'contact' => 'required|string'
        ]);

        $account = WhatsAppAccount::findOrFail($request->account_id);
        $this->authorize('useAccount', $account);

        $messages = $account->messages()
            ->where(function($query) use ($request) {
                $query->where('from', $request->contact)
                    ->orWhere('to', $request->contact);
            })
            ->with('media')
            ->orderBy('timestamp')
            ->paginate(50);

        return response()->json($messages);
    }
}