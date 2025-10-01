<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioService
{
    public function sendWhatsAppMessage($userPhone, $variables = [], $isTemplate = false, $isDetailTemplate = false)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');

        $twilio = new Client($twilioSid, $twilioToken);

        try {
            $payload = [
                'from' => "whatsapp:" . $twilioWhatsAppNumber,
            ];

            if ($isTemplate) {
                $payload['contentSid'] = 'HXa0c01cf804f122866aa8df9b00006171'; 
                $payload['contentVariables'] = json_encode([
                    'body' => $variables['body'],
                    'confirm' => $variables['confirm'],
                    'confirm_text' => $variables['confirm_text'],
                    'sechedul' => $variables['sechedul'],
                    'sechedul_text' => $variables['sechedul_text'],
                    'cancel' => $variables['cancel'],
                    'cancel_text' => $variables['cancel_text'],

                ]);
            } elseif ($isDetailTemplate) {
                $payload['contentSid'] = 'HX18d36afad0617eb2413877a60226ec75';
                $payload['contentVariables'] = json_encode([
                    'body' => $variables['body'],
                    'confirm' => $variables['confirm'],
                    'confirm_text' => $variables['confirm_text'],
                    'edit' => $variables['edit'],
                    'edit_text' => $variables['edit_text'],
                ]);
            } else {
                $payload['body'] = $variables['body'];
            }


            $messageResponse = $twilio->messages->create(
                "whatsapp:{$userPhone}",
                $payload
            );

            Log::info('WhatsApp message sent successfully:', [
                'Message SID' => $messageResponse->sid,
                'User Phone' => $userPhone,
                'Is Template' => $isTemplate ? 'Yes' : 'No',
            ]);

            return response()->json(['message' => 'WhatsApp message sent successfully']);
        } catch (\Exception $e) {
            Log::error('Twilio API error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function sendTypingIndicator($userPhone)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');

        $twilio = new Client($twilioSid, $twilioToken);

        try {
            $messageResponse = $twilio->messages->create(
                "whatsapp:{$userPhone}",
                [
                    'from' => "whatsapp:" . $twilioWhatsAppNumber,
                    'body' => "\u{200B}",
                    'persistentAction' => ['typing']
                ]
            );

            Log::info('Typing indicator sent successfully:', [
                'Message SID' => $messageResponse->sid,
                'User Phone' => $userPhone
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send typing indicator: ' . $e->getMessage());
            return false;
        }
    }
}