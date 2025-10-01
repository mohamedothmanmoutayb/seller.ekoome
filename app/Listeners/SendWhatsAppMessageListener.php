<?php

namespace App\Listeners;

use App\Events\NewLeadCreated;
use App\Http\Services\TwilioService;
use App\Models\Lead;
use App\Models\WhatsappConfirmationTemplate;
use App\Models\WhatsAppSetting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessageListener implements ShouldQueue
{
    // public function handle(NewLeadCreated $event)
    // {
    //     $lead = $event->lead;
        
    //     if (!$lead || !$lead->phone) {
    //         Log::error('Invalid lead data in SendWhatsAppMessageListener');
    //         return;
    //     }
    
    //     $whatsappSettings = WhatsAppSetting::where('user_id', $lead->id_user)->first();
    
    //     if ($whatsappSettings && $whatsappSettings->chatbot_enabled === false) {
    //         return;
    //     }
    
    //     $insufficientProducts = [];
    //     foreach ($lead->products ?? [] as $product) {
    //         $quantityRequested = $product->pivot->quantity ?? 0;
    //         if (($product->quantity_real ?? 0) < $quantityRequested) {
    //             $insufficientProducts[] = $product->name ?? 'Unknown Product';
    //         }
    //     }
    
    //     if (!empty($insufficientProducts)) {
    //         $this->sendStockAlert($lead, $insufficientProducts);
    //         return;
    //     }
    
    //     $template = WhatsappConfirmationTemplate::getTemplate(
    //         WhatsappConfirmationTemplate::STATUS_CONFIRMATION,
    //         $lead->id_country
    //     );
    
    //     if (!$template) {
    //         Log::error('No WhatsApp confirmation template found for country: ' . $lead->id_country);
    //         return;
    //     }
    
    //     $message = $this->replaceTemplateVariables($template->template, $lead);
    
    //     $buttons = [];
    //     $templateButtons = $template->buttons ?? []; 
        
    //     if (!empty($templateButtons)) {
    //         foreach ($templateButtons as $button) {
    //             $buttonText = $this->replaceTemplateVariables($button['text'], $lead);
    //             $buttonId = $button['id'];
                
    //             if (str_contains($buttonId, 'confirm')) {
    //                 $buttonId = 'confirm_' . $lead->id;
    //             } elseif (str_contains($buttonId, 'cancel')) {
    //                 $buttonId = 'cancel_' . $lead->id;
    //             } elseif (str_contains($buttonId, 'schedule')) {
    //                 $buttonId = 'schedule_' . $lead->id;
    //             }
                
    //             $buttons[$buttonId] = $buttonText;
    //         }
    //     }

    //      Log::info('Final buttons for WhatsApp message:', ['buttons' => $buttons]);

    
    //     $twilioService = new TwilioService();
    //     $twilioService->sendWhatsAppMessage(
    //         $lead->phone,
    //         [
    //             'body' => $message,
    //             'buttons' => $buttons
    //         ],
    //         true
    //     );
    
    //     Log::info('Sent WhatsApp confirmation for Lead ID: ' . $lead->id);
    // }
    
    // protected function sendStockAlert(Lead $lead, array $insufficientProducts)
    // {
    //     $template = WhatsappConfirmationTemplate::getTemplate(
    //         'Stock Alert Message', 
    //         $lead->id_country
    //     );
    
    //     if (!$template) {
    //         $message = trans('messages.order_alert_stock', [
    //             'order_id' => $lead->id,
    //             'customer_name' => $lead->name,
    //             'items' => implode("\n", $insufficientProducts)
    //         ], $lead->country[0]->language ?? 'ar');
    //     } else {
    //         $message = $this->replaceTemplateVariables($template->template, $lead);
    //     }
    
    //     $twilioService = new TwilioService();
    //     $twilioService->sendWhatsAppMessage(
    //         $lead->phone,
    //         ['body' => $message]
    //     );
    
    //     Log::error('Insufficient product quantities for Lead ID: ' . $lead->id);
    // }
    
    // protected function replaceTemplateVariables(string $template, Lead $lead): string
    // {
    //     if (!$lead->relationLoaded('products')) {
    //         $lead->load('products');
    //     }
    
    //     $replacements = [
    //         '{{ customer-name }}' => $lead->name ?? 'Customer',
    //         '{{ customer-phone }}' => $lead->phone ?? '',
    //         '{{ customer-email }}' => $lead->email ?? '',
    //         '{{ customer-address }}' => $this->formatAddress($lead),
    //         '{{ customer-city }}' => $lead->cities[0]->name ?? '',
    //         '{{ customer-country }}' => $lead->country[0]->name ?? '',
    //         '{{ order-id }}' => $lead->id_order ?? '',
    //         '{{ order-reference }}' => $lead->n_lead ?? $lead->id_order ?? '',
    //         '{{ order-date }}' => $lead->created_at?->format('F j, Y') ?? '',
    //         '{{ delivery-date }}' => $lead->delivery_date?->format('F j, Y') ?? 'soon',
    //         '{{ order-total }}' => number_format($lead->amount, 2) ?? '0.00',
    //         '{{ order-status }}' => ucfirst(str_replace('_', ' ', $lead->status_livrison)) ?? '',
    //         '{{ payment-method }}' => ucfirst($lead->payment_method) ?? '',
    //         '{{ support-email }}' => $lead->user->email ?? 'Our Company',
    //         '{{ support-phone }}' => $lead->user->phone ?? '',
    //         '{{ insufficient-products }}' => implode("\n", array_map(function($product) {
    //             return "- " . $product;
    //         }, $insufficientProducts ?? [])),
    //     ];
    
    //     $template = str_replace(
    //         array_keys($replacements),
    //         array_values($replacements),
    //         $template
    //     );
    
    //     return $this->replaceProductBlocks($template, $lead);
    // }
    
    // protected function replaceProductBlocks(string $template, Lead $lead): string
    // {
    //     $productPattern = '/{{ products-start }}(.*?){{ products-end }}/s';
        
    //     if (preg_match($productPattern, $template, $matches)) {
    //         $productTemplate = $matches[1];
    //         $productsContent = '';
            
    //         foreach ($lead->products as $product) {
    //             $productContent = str_replace(
    //                 [
    //                     '{{ product-name }}',
    //                     '{{ product-quantity }}',
    //                     '{{ product-price }}',
    //                     '{{ product-total }}',
    //                 ],
    //                 [
    //                     $product->name,
    //                     $product->pivot->quantity ?? 0,
    //                     number_format($product->price, 2),
    //                     number_format(($product->pivot->quantity ?? 0) * $product->price, 2),
    //                 ],
    //                 $productTemplate
    //             );
    //             $productsContent .= $productContent;
    //         }
            
    //         $template = preg_replace($productPattern, $productsContent, $template);
    //     }
        
    //     return $template;
    // }
    
    // protected function formatAddress(Lead $lead): string
    // {
    //     $addressParts = [
    //         $lead->address ?? '',
    //         $lead->cities[0]->name ?? '',
    //         $lead->country[0]->name ?? '',
    //         $lead->zip_code ?? ''
    //     ];
        
    //     return implode(', ', array_filter($addressParts));
    // }
    public function handle(NewLeadCreated $event)
    {
        $lead = $event->lead;
        
        if (!$lead || !$lead->phone) {
            Log::error('Invalid lead data in SendWhatsAppMessageListener');
            return;
        }

        $whatsappSettings = WhatsAppSetting::where('user_id', $lead->id_user)->first();

        if ($whatsappSettings && $whatsappSettings->chatbot_enabled === false) {
            // $language = $lead->country[0]->language ?? 'en';
            // $message = trans('messages.chatbot_disabled', [], $language);
            
            // $twilioService = new TwilioService();
            // $twilioService->sendWhatsAppMessage(
            //     $lead->phone,
            //     ['body' => $message]
            // );
            return;
        }

        $twilioService = new TwilioService();
        $language = $lead->country->first()->language ?? null;
        $currency = optional($lead->country)->currency ?? 'MAD';
        Log::info('Language detected: ' . ($language ?? 'ar'));

        $insufficientProducts = [];
        foreach ($lead->products ?? [] as $product) {
            $quantityRequested = $product->pivot->quantity ?? 0;
            if (($product->quantity_real ?? 0) < $quantityRequested) {
                $insufficientProducts[] = trans('messages.stock_alert_item', [
                    'product' => $product->name ?? 'Unknown Product',
                    'available' => $product->quantity_real ?? 0,
                    'needed' => $quantityRequested
                ], $language);
            }
        }

        if (!empty($insufficientProducts)) {
            $message = trans('messages.order_alert_stock', [
                'order_id' => $lead->id,
                'customer_name' => $lead->name,
                'items' => implode("\n", $insufficientProducts)
            ], $language);

            Log::error('Insufficient product quantities for Lead ID: ' . ($lead->id));
            
            $twilioService->sendWhatsAppMessage(
                $lead->phone,
                ['body' => $message]
            );
            return;
        }

        $orderItems = [];
        foreach ($lead->products ?? [] as $product) {
            $orderItems[] = trans('messages.order_item', [
                'product' => $product->name ?? 'Unknown Product',
                'quantity' => $product->pivot->quantity ?? 0
            ], $language);
        }

        $message = trans('messages.order_confirmation', [
            'order_id' => $lead->id,
            'customer_name' => $lead->name,
            'items' => implode("\n", $orderItems),
            'total' => $lead->lead_value,
            'currency' => $currency,
            'confirm' => trans('messages.confirm_button', [], $language),
            'cancel' => trans('messages.cancel_button', [], $language)
        ], $language);

        Log::info('Sending WhatsApp message for Lead ID: ' . ($lead->id));

        $twilioService->sendWhatsAppMessage(
            $lead->phone,
            [
                'body' => $message,
                'confirm' => 'confirm_' . ($lead->id),
                'confirm_text' => trans('messages.confirm_now_button', [], $language),
                'sechedul' => 'sechedul_' . ($lead->id),
                'sechedul_text' => trans('messages.schedule_button', [], $language),
                'cancel' => 'cancel_' . ($lead->id),
                'cancel_text' => trans('messages.cancel_button', [], $language)
            ],
            true
        );
    }
}