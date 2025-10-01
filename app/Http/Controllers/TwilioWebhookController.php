<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Services\TwilioService;
use App\Models\Countrie;
use App\Models\WhatsAppSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TwilioWebhookController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function handleResponse(Request $request)
    {
        $response = strtolower(trim($request->input('Body')));
        $userPhone = str_replace("whatsapp:", "", $request->input('From'));

        Log::info('WhatsApp message received', ['phone' => $userPhone, 'message' => $response]);
        Log::info('Request data', ['request' => $request->input('ButtonPayload')]);

        if ($response == '1️⃣ تأكيد الآن' || $response == "2️⃣ جدولة التسليم"  
            || $response == "إلغاء" || $response == "cancel"
            || $response == '1️⃣ Confirm Now' || $response == "2️⃣ Schedule Delivery") {
            $this->handleLeadConfirmation($request, $response, $userPhone);
            return response()->json(['message' => 'Lead confirmation handled']);
        }


        $session = $this->getOrCreateSession($userPhone);

        if($response == 'confirm informations' || $response == 'edit informations' || $response == 'تأكيد المعلومات' || $response == 'تعديل المعلومات') {
            $this->handleDetailsConfirmation($request, $response, $session);
            return response()->json(['message' => 'Details confirmation handled']);
        }

        if ($session->state === 'awaiting_details_confirmation') {
            $this->handleDetailsConfirmation($request, $response, $session);
            return response()->json(['message' => 'Details confirmation handled']);
        }   

        if ($session->state === 'editing_lead') {
            $this->handleLeadEditing($response, $session);
            return response()->json(['message' => 'Lead editing handled']);
        }

        if ($session->state === 'wait_confirmation') {
            $this->handleLeadConfirmation($request, $response, $userPhone);
            return response()->json(['message' => 'Lead confirmation handled']);
        }

        if ($session->state === 'awaiting_delivery_date') {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $response)) {
                $context = json_decode($session->context, true);
                $lead = Lead::where('id', $context['lead_id'])
                    ->where(function($query) use ($userPhone) {
                        $query->where('phone', $userPhone)
                            ->orWhere('phone2', $userPhone);
                    })
                    ->first();

                if($lead) {
                    return $this->processDeliveryDate($response, $session, $lead);
                } else {
                    $this->sendMessage(
                        $userPhone,
                        trans('messages.lead_not_found'),
                        $session->language
                    );
                    return null;
                }
            } else {
                $this->sendMessage(
                    $userPhone,
                    trans('messages.invalid_date_format'),
                    $session->language
                );
                return $this->requestDeliveryDate($session);
            }
        }

        $lead = Lead::where('phone', $userPhone)
            ->orWhere('phone2', $userPhone)
            ->first();
            
        Log::info('Lead found', ['lead' => $lead]); 
        return $this->callAIAssistance($response, $session, $userPhone);
    }

    private function getOrCreateSession($userPhone)
    {
        $lead = Lead::where('phone', $userPhone)
            ->orWhere('phone2', $userPhone)
            ->with('country') 
            ->first();

        Log::info('Lead country', ['lead' => $lead->country[0]->language]);
        if ($lead && $lead->country) {
            $language = $lead->country[0]->language ?? 'en';
        }

        return Session::firstOrCreate(
            ['phone' => $userPhone],
            [
                'state' => 'initial',
                'context' => json_encode([]),
                'language' => $language
            ]
        );
    }

    private function sendMessage($phone, $message, $language = null)
    {
        if ($language === 'ar') {
            $message = "\xE2\x80\x8F" . $message . "\xE2\x80\x8F";
        }

        $this->twilioService->sendWhatsAppMessage($phone, ['body' => $message]);
    }

    private function handleLeadConfirmation($request, $response, $userPhone)
    {
        $normalizedResponse = preg_replace('/[^\w\s]/u', '', $response);
        $normalizedResponse = strtolower(trim($normalizedResponse));

        $leadId = $this->extractLeadId($request, $response);

        Log::info('Lead ID extracted', ['lead_id' => $leadId, 'normalized_response' => $normalizedResponse]);

        if (!$leadId) {
            return null;
        }

        $lead = Lead::where('id', $leadId)
            ->where(function($query) use ($userPhone) {
                $query->where('phone', $userPhone)
                    ->orWhere('phone2', $userPhone);
            })
            ->first();

        if ($lead && $lead->country) {
            $language = $lead->country[0]->language ?? 'en';
        }

        if (!$lead) {
            Log::warning('Lead not found:', ['lead_id' => $leadId, 'user_phone' => $userPhone]);
            $this->sendMessage(
                $userPhone,
                trans('messages.lead_not_found'),
                $language
            );
            return null;
        }

        $session = $this->updateSessionForLead($userPhone, $lead);

        if ($normalizedResponse === 'cancel' || $request->input('ButtonPayload') === 'cancel_'.$leadId) {
            $this->cancelLead($lead, $userPhone);
            return $lead;
        }

        if ($normalizedResponse === '1' || 
            $normalizedResponse === '1 confirm now' || 
            $request->input('ButtonPayload') === 'confirm_'.$leadId) {
            $this->confirmLead($lead, $userPhone);
            return $lead;
        }

        if ($normalizedResponse === '2' || 
            $normalizedResponse === '2 schedule delivery'|| 
            $request->input('ButtonPayload') === 'sechedul_'.$leadId) {
            $this->requestDeliveryDate($session);
            return $lead;
        }

        $this->sendMessage(
            $userPhone,
            trans('messages.invalid_confirmation_option'),
            $session->language
        );

        return $lead;
    }

    private function updateSessionForLead($userPhone, $lead)
    {
        if ($lead && $lead->country) {
            $language = $lead->country[0]->language ?? 'en';
        }

        return Session::updateOrCreate(
            ['phone' => $userPhone],
            [
                'state' => 'wait_confirmation',
                'seller_id' => $lead->id_user,
                'context' => json_encode(['lead_id' => $lead->id]),
                'language' => $language 
            ]
        );
    }

    private function confirmLead($lead, $userPhone)
    {
        $lead->update([
            'status_confirmation' => 'confirmed',
            'delivered_at' => now() 
        ]);

        if ($lead && $lead->country) {
            $language = $lead->country[0]->language ?? 'en';
        }

        $this->sendMessage(
            $userPhone,
            trans('messages.order_confirmed_immediate'),
            $language
        );

        $session = Session::where('phone', $userPhone)->first();
        $session->update(['state' => 'awaiting_details_confirmation']);

        $this->sendCustomerDetailsConfirmation($lead, $session);
    }

    private function cancelLead($lead, $userPhone)
    {
        $lead->update([
            'status_confirmation' => 'cancelled'
        ]);

        Session::where('phone', $userPhone)
            ->update(['state' => 'initial']);

        $this->sendMessage(
            $userPhone,
            trans('messages.order_cancelled'),
            $lead->language 
        );
    }

    private function requestDeliveryDate($session)
    {
        $message = trans('messages.request_delivery_date') . "\n\n";
        $message .= trans('messages.date_format_hint');
        
        $this->sendMessage($session->phone, $message, $session->language);
        $session->update(['state' => 'awaiting_delivery_date']);
    }

    private function processDeliveryDate($date, $session, $lead)
    {
        Log::info('Processing delivery date', ['date' => $date, 'session' => $session->phone]);
        try {
            $deliveryDate = Carbon::parse($date);
            $minDate = now()->addDays(1);
            $maxDate = now()->addMonths(2);
            
            if ($deliveryDate->lt($minDate)) {
                $this->sendMessage(
                    $session->phone,
                    trans('messages.delivery_date_too_early', ['date' => $minDate->format('Y-m-d')]),
                    $session->language
                );
                return;
            }
            
            if ($deliveryDate->gt($maxDate)) {
                $this->sendMessage(
                    $session->phone,
                    trans('messages.delivery_date_too_late', ['date' => $maxDate->format('Y-m-d')]),
                    $session->language
                );
                return;
            }
            
            $lead->update([
                'status_confirmation' => 'confirmed',
                'delivered_at' => $deliveryDate
            ]);
            
            $this->sendMessage(
                $session->phone,
                trans('messages.order_confirmed_scheduled', ['date' => $deliveryDate->format('Y-m-d')]),
                $session->language
            );
            
            $session->update(['state' => 'awaiting_details_confirmation']);
            $this->sendCustomerDetailsConfirmation($lead, $session);
        } catch (\Exception $e) {
            Log::error('Error processing delivery date: ' . $e->getMessage(), [
                'date_input' => $date,
                'session_phone' => $session->phone,
            ]);
            $this->sendMessage(
                $session->phone,
                trans('messages.invalid_date_format'),
                $session->language
            );
        }
    }

    private function extractLeadId($request, $response)
    {
        if ($request->input('ButtonPayload')) {
            $payload = $request->input('ButtonPayload');
            return str_replace(['confirm_', 'cancel_','sechedul_'], '', $payload);
        }

        if (preg_match('/lead id: (\d+)/i', $response, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function initiateEditProcess($session, $lead)
    {
        $session->update([
            'state' => 'editing_lead',
            'context' => json_encode([
                'lead_id' => $lead->id,
                'edit_step' => 'name'
            ])
        ]);

        $this->sendMessage(
            $session->phone,
            trans('messages.edit_lead_name_prompt', ['current' => $lead->name]),
            $session->language
        );
    }

    private function sendCustomerDetailsConfirmation($lead, $session)
    {
        $message = trans('messages.customer_details_confirmation', [
            'name' => $lead->name,
            'phone' => $lead->phone,
            'email' => $lead->email ?? trans('messages.not_provided'),
            'address' => $lead->address ?? trans('messages.not_provided'),
        ], $session->language);

        $message .= "\n\n" . trans('messages.confirm_details_prompt');

        $this->twilioService->sendWhatsAppMessage(
            $session->phone,
            [
                'body' => $message,
                'confirm' => 'confirm_' . ($lead->id),
                'confirm_text' => trans('messages.confirm_button', [], $session->language),
                'edit' => 'edit_' . ($lead->id),
                'edit_text' => trans('messages.edit_button', [], $session->language),
            ],
            false,
            true 
        );

        $session->update(['state' => 'awaiting_details_confirmation']);
    }

    private function handleDetailsConfirmation($request, $response, $session)
    {
        $context = json_decode($session->context, true);
        Log::info('Session context', ['context' => $context]);
        $lead = Lead::find($context['lead_id'] ?? null);

        if (!$lead) {
            $this->sendMessage(
                $session->phone,
                trans('messages.lead_not_found'),
                $session->language
            );
            $session->update(['state' => 'initial']); 
            return;
        }

        $normalized = strtolower(trim($response));
        
        if ($normalized === '1' || 
            $normalized === 'confirm informations' || 
            $normalized === 'تأكيد المعلومات' ||
            $request->input('ButtonPayload') === 'confirm_'.$lead->id) {
            
            $this->sendMessage(
                $session->phone,
                trans('messages.details_confirmed'),
                $session->language
            );
            
            $session->update([
                'state' => 'initial',
                'context' => json_encode([])
            ]);
        }
        elseif ($normalized === '2' || 
            $normalized === 'edit informations' || 
            $normalized === 'تعديل المعلومات' ||
            $request->input('ButtonPayload') === 'edit_'.$lead->id) {
            $this->initiateEditProcess($session, $lead);
        }
        else {
            $this->sendMessage(
                $session->phone,
                trans('messages.invalid_confirmation_option'),
                $session->language
            );
        }
    }

    private function handleLeadEditing($response, $session)
    {
        Log::info('Handling lead editing', [' session' => $session]);
        $context = json_decode($session->context, true);
        $leadId = $context['lead_id'] ?? null;
        $currentStep = $context['edit_step'] ?? null;

        if (!$leadId || !$currentStep) {
            $this->sendMessage(
                $session->phone,
                trans('messages.edit_session_expired'),
                $session->language
            );
            $session->update(['state' => 'initial']);
            return;
        }

        $lead = Lead::find($leadId);
        if (!$lead) {
            $this->sendMessage(
                $session->phone,
                trans('messages.lead_not_found'),
                $session->language
            );
            $session->update(['state' => 'initial']);
            return;
        }

        //INSTEAD OF EMAIL DO CITY

        switch ($currentStep) {
            case 'name':
                $this->processNameUpdate($response, $session, $lead, $context);
                break;
            case 'phone':
                $this->processPhoneUpdate($response, $session, $lead, $context);
                break;
            case 'email':
                $this->processEmailUpdate($response, $session, $lead, $context);
                break;
            case 'address':
                $this->processAddressUpdate($response, $session, $lead, $context);
                break;
            case 'confirm':
                $this->processEditConfirmation($response, $session, $lead);
                break;
            default:
                $session->update(['state' => 'initial']);
                break;
        }
    }

    private function processNameUpdate($response, $session, $lead, $context)
    {
        $response = trim($response);
        if (empty($response)) {
            $this->sendMessage(
                $session->phone,
                trans('messages.invalid_name'),
                $session->language
            );
            return;
        }

        $context['name'] = $response;
        $context['edit_step'] = 'phone';
        $session->update(['context' => json_encode($context)]);

        $this->sendMessage(
            $session->phone,
            trans('messages.edit_lead_phone_prompt', ['current' => $lead->phone]),
            $session->language
        );
    }

    private function processPhoneUpdate($response, $session, $lead, $context)
    {
        $response = trim($response);
        if (!preg_match('/^\+?[\d\s\-]+$/', $response)) {
            $this->sendMessage(
                $session->phone,
                trans('messages.invalid_phone'),
                $session->language
            );
            return;
        }

        $context['phone'] = $response;
        $context['edit_step'] = 'email';
        $session->update(['context' => json_encode($context)]);

        $this->sendMessage(
            $session->phone,
            trans('messages.edit_lead_email_prompt', ['current' => $lead->email ?? trans('messages.not_provided')]),
            $session->language
        );
    }

    private function processEmailUpdate($response, $session, $lead, $context)
    {
        $response = trim($response);
        if (strtolower($response) === 'skip') {
            $this->sendMessage(
                $session->phone,
                trans('messages.field_skipped'),
                $session->language
            );
            $context['email'] = $lead->email;
        } elseif (!empty($response) && !filter_var($response, FILTER_VALIDATE_EMAIL)) {
            $this->sendMessage(
                $session->phone,
                trans('messages.invalid_email'),
                $session->language
            );
            return;
        } else {
            $context['email'] = $response ?: null;
        }

        $context['edit_step'] = 'address';
        $session->update(['context' => json_encode($context)]);

        $this->sendMessage(
            $session->phone,
            trans('messages.edit_lead_address_prompt', ['current' => $lead->address ?? trans('messages.not_provided')]),
            $session->language
        );
    }

    private function processAddressUpdate($response, $session, $lead, $context)
    {
        $response = trim($response);
        if (strtolower($response) === 'skip') {
            $this->sendMessage(
                $session->phone,
                trans('messages.field_skipped'),
                $session->language
            );
            $context['address'] = $lead->address;
        } else {
            $context['address'] = $response ?: null;
        }

        $context['edit_step'] = 'confirm';
        $session->update(['context' => json_encode($context)]);

        $confirmationMessage = trans('messages.edit_lead_confirmation', [
            'name' => $context['name'] ?? $lead->name,
            'phone' => $context['phone'] ?? $lead->phone,
            'email' => $context['email'] ?? ($lead->email ?? trans('messages.not_provided')),
            'address' => $context['address'] ?? ($lead->address ?? trans('messages.not_provided'))
        ], $session->language);

        $confirmationMessage .= "\n\n" . trans('messages.confirm_edit_prompt');

        $this->sendMessage(
            $session->phone,
            $confirmationMessage,
            $session->language
        );
    }

    private function processEditConfirmation($response, $session, $lead)
    {
        $context = json_decode($session->context, true);
        $normalizedResponse = strtolower(trim($response));

        if ($normalizedResponse === 'yes' || $normalizedResponse === '1' || $normalizedResponse === 'confirm') {
            $updates = [
                'name' => $context['name'] ?? $lead->name,
                'phone' => $context['phone'] ?? $lead->phone,
                'email' => $context['email'] ?? $lead->email,
                'address' => $context['address'] ?? $lead->address
            ];

            $lead->update($updates);

            $this->sendMessage(
                $session->phone,
                trans('messages.lead_updated_successfully'),
                $session->language
            );
        } else {
            $this->sendMessage(
                $session->phone,
                trans('messages.edit_cancelled'),
                $session->language
            );
        }

        $session->update(['state' => 'initial']);
    }

    private function callAIAssistance($question, $session, $userPhone)
    {
        Log::info('Calling AI assistance', ['question' => $question, 'session' => $session->phone]);
        try {
            $lead = Lead::where('phone', $userPhone)
                ->orWhere('phone2', $userPhone)
                ->first();
                Log::info('Lead found for AI assistance', ['lead' => $lead]);
            if ($lead) {
                $whatsappSettings = WhatsAppSetting::where('user_id', $lead->id_user)->first();
                Log::info('WhatsApp Settings:', ['settings' => $whatsappSettings]);
                if ($whatsappSettings && $whatsappSettings->chatbot_enabled === false) {
                    Log::info('Chatbot is disabled for this seller', ['seller_id' => $lead->id_user]);
                    $message = trans('messages.chatbot_disabled', [], $session->language);
                    $this->sendMessage($session->phone, $message, $session->language);
                    return response()->json(['message' => 'Chatbot is disabled for this seller']);
                }
            }

            $response = Http::post(url('api/ai/query'), [
                'message' => $question,
                'phone' => $userPhone 
            ]);
                
            if ($response->successful()) {
                Log::info('AI Service Response:', ['response' => $response->json()]);
                $message = $response->json()['response'] ?? trans('messages.ai_no_response');
                $this->sendMessage($session->phone, $message, $session->language);
                return response()->json(['message' => 'AI response sent']);
            }
            
            Log::error('AI Service Error: ' . $response->body());
            $this->sendMessage(
                $session->phone,
                trans('messages.ai_unavailable'),
                $session->language
            );
            return response()->json(['message' => 'AI service error'], 500);
            
        } catch (\Exception $e) {
            Log::error('AI Connection Error: ' . $e->getMessage());
            $this->sendMessage(
                $session->phone,
                trans('messages.ai_connection_error'),
                $session->language
            );
            return response()->json(['message' => 'AI connection error'], 500);
        }
    }
}