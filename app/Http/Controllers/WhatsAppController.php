<?php

namespace App\Http\Controllers;

use App\Http\Services\TwilioService;
use App\Models\DeliveryAttempt;
use App\Models\Lead;
use App\Models\User;
use App\Models\WhatsAppAccount;
use App\Models\WhatsappAgent;
use App\Models\WhatsAppBusinessAccount;
use App\Models\WhatsAppSetting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function indexSettings(Request $request)
    {
        $settings = WhatsAppSetting::where('user_id', auth()->id())->first();
        return view('backend.plugins.whatsapp');
    }

    public function getSettings()
    {
        $settings = WhatsAppSetting::where('user_id', Auth::id())->first();
        return response()->json([
            'settings' => $settings
        ]);
    }

    public function syncTemplates(Request $request)
    {
        $accountId = $request->input('account_id');
        
        
        return response()->json([
            'success' => true,
            'message' => 'Templates synced successfully'
        ]);
    }

    public function assignAgents(Request $request)
    {

        $request->validate([
            'account_id' => 'required|exists:whatsapp_business_accounts,id',
            'agent_ids' => 'required|array',
            'agent_ids.*' => 'exists:users,id'
        ]);

        try {
            $accountId = $request->account_id;
            $agentIds = $request->agent_ids;

            WhatsappAgent::where('whats_app_business_account_id', $accountId)->delete();

            foreach ($agentIds as $agentId) {
                WhatsappAgent::create([
                    'whats_app_business_account_id' => $accountId, 
                    'user_id' => $agentId
                ]);
            }

            return response()->json([
                'message' => 'Agents assigned successfully',
                'assigned_count' => count($agentIds)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to assign agents: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'chatbot_enabled' => 'required|string',
            'active_languages' => 'required|string',
            // 'active_chats' => 'required|string'
        ]);

        $settings = WhatsAppSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'chatbot_enabled' => $validated['chatbot_enabled'] == 'true' ? 1 : 0, 
                'active_languages' => $validated['active_languages'],
                // 'active_chats' => $validated['active_chats']
            ]
        );

        return response()->json([
            'message' => 'Settings saved successfully',
            'settings' => $settings
        ]);
    }

    public function accountDetails(Request $request)
    {

        $account = WhatsAppBusinessAccount::with([
            'templates',    
            'flows', 
            'assignedUsers' 
        ])->findOrFail($request->account_id);

        $assignedAgents = $account->assignedUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'id_role' => $user->id_role,
            ];
        });

        return response()->json([
            'account' => $account,
            'templates' => $account->templates,
            'flows' => $account->flows,
            'assigned_agents' => $assignedAgents
        ]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'chatbot_enabled' => 'boolean',
            'active_languages' => 'array'
        ]);

        $settings = WhatsAppSetting::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        return response()->json(['message' => 'Settings updated', 'settings' => $settings]);
    }

    public function notifyMissedCall(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:delivery_attempts,id'
        ]);

        $attempt = DeliveryAttempt::with('lead')->find($data['id']);
        
        if (!$attempt) {
            return response()->json(['error' => 'Attempt not found'], 404);
        }

        $phone = $attempt->lead->phone;
        $message = "We tried to contact you regarding your delivery, but we couldn't reach you. Please get in touch.";

        $twilioService = new TwilioService();
        
        try {
            $twilioService->sendWhatsAppMessage($phone, [
                'body' => $message
            ], false);

            $attempt->update(['customer_answered' => true]);

            return response()->json(['message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   public function accessToken(Request $request)
   {

        $validated = $request->validate([
            'code' => 'required|string',
            'waba_id' => 'required|string', 
            'phone_number_id' => 'required|string', 
            'business_id' => 'required|string'
        ]);

        $client = new Client();
        
        try {
            $phoneResponse = $client->get("https://graph.facebook.com/v23.0/{$validated['phone_number_id']}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('WHATSAPP_ACCESS_TOKEN')
                ]
            ]);

            $phoneData = json_decode($phoneResponse->getBody(), true);
            $phoneNumber = $phoneData['display_phone_number'] ?? $phoneData['verified_name'] ?? 'Unknown';

            $wabaResponse = $client->get("https://graph.facebook.com/v23.0/{$validated['waba_id']}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('WHATSAPP_ACCESS_TOKEN')
                ],
                'query' => [
                    'fields' => 'name,currency,timezone_id,account_review_status'
                ]
            ]);

            
            $wabaData = json_decode($wabaResponse->getBody(), true);

            $businessResponse = $client->get("https://graph.facebook.com/v23.0/{$validated['business_id']}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('WHATSAPP_ACCESS_TOKEN')
                ],
                'query' => [
                    'fields' => 'name'
                ]
            ]);

            $businessData = json_decode($businessResponse->getBody(), true);

            $templateLimitResponse = $client->get("https://graph.facebook.com/v23.0/{$validated['waba_id']}/message_templates", [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('WHATSAPP_ACCESS_TOKEN')
                ],
                'query' => [
                    'limit' => 1,
                    'fields' => 'id'
                ]
            ]);

            $templateLimitData = json_decode($templateLimitResponse->getBody(), true);
            $templateLimit = $templateLimitData['paging']['total_count'] ?? 0;
            $whatsappAccount = WhatsAppBusinessAccount::updateOrCreate(
                ['account_id' => $validated['waba_id']],
                [
                    'user_id' => auth()->id(),
                    'account_id' => $validated['waba_id'],
                    'business_id' => $validated['business_id'],
                    'phone_number' => $phoneNumber,
                    'phone_number_id' => $validated['phone_number_id'],
                    'name' => $wabaData['name'] ?? $businessData['name'] ?? null,
                    'currency' => $wabaData['currency'] ?? null,
                    'timezone' => $wabaData['timezone_id'] ?? $businessData['timezone_id'] ?? null,
                    'message_template_limit' => $templateLimit,
                    'access_token' => encrypt(env('WHATSAPP_ACCESS_TOKEN')),
                    'webhook_verify_token' => \Illuminate\Support\Str::random(40),
                    'status' => 'active',
                    'meta_data' => json_encode([
                        'waba_data' => array_merge($wabaData, [
                            'account_review_status' => $wabaData['account_review_status'] ?? null,
                        ]),
                        'business_data' => [
                            'name' => $businessData['name'] ?? null,
                        ],
                        'phone_data' => $phoneData,
                        'template_limit' => $templateLimit,
                        'connected_at' => now()->toISOString(),
                        'webhook_url' => route('webhook.whatsapp', ['accountId' => 'TODO_REPLACE_WITH_ACCOUNT_ID']),
                        'api_version' => 'v23.0'
                    ]),
                    'last_synced_at' => now()
                ]
            );


            $metaData = json_decode($whatsappAccount->meta_data, true);
            $metaData['webhook_url'] = route('webhook.whatsapp', ['accountId' => $whatsappAccount->id]);
            $whatsappAccount->update(['meta_data' => json_encode($metaData)]);

            $webhookSubscribeResponse = $client->post("https://graph.facebook.com/v23.0/{$validated['waba_id']}/subscribed_apps", [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('WHATSAPP_ACCESS_TOKEN')
                ]
            ]);

            $webhookSubscribeData = json_decode($webhookSubscribeResponse->getBody(), true);

            $updatedMetaData = json_decode($whatsappAccount->meta_data, true);
            $updatedMetaData['webhook_subscription'] = $webhookSubscribeData;
            $updatedMetaData['webhook_subscribed_at'] = now()->toISOString();

            $whatsappAccount->update(['meta_data' => json_encode($updatedMetaData)]);

            Log::info('WhatsApp Business Account connected successfully', [
                'account_id' => $whatsappAccount->id,
                'waba_id' => $validated['waba_id'],
                'business_id' => $validated['business_id'],
                'phone_number' => $phoneNumber,
                'user_id' => auth()->id()
            ]);

            try {
                $intermediaryUrl = env('INTERMEDIARY_URL') . '/api/register-client';

                $registerResponse = Http::post($intermediaryUrl, [
                    'name'            => auth()->user()->name ?? 'Client',
                    'domain'          => config('app.url'), 
                    'waba_id'         => $validated['waba_id'],
                    'phone_number_id' => $validated['phone_number_id'],
                ]);

                if ($registerResponse->successful()) {
                    Log::info('✅ Client registered in intermediary app', $registerResponse->json());
                } else {
                    Log::warning('⚠️ Failed to register client in intermediary', [
                        'status' => $registerResponse->status(),
                        'body'   => $registerResponse->body()
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('⚠️ Error registering client in intermediary: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'WhatsApp account connected successfully',
                'account' => $whatsappAccount
            ]);
            
        } catch (\Exception $e) {
            Log::error('WhatsApp token exchange failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to connect WhatsApp account: ' . $e->getMessage()
            ], 500);
        }
   }

}
