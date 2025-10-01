<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\DeliveryAttempt;
use App\Models\WhatsAppSetting;
use App\Models\Flow;
use App\Models\WhatsAppBusinessAccount;
use App\Models\WhatsAppMessageTemplate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadObserver
{

    public function created(Lead $lead)
    {
        Log::info("=== LEAD OBSERVER STARTED ===");
        Log::info("Lead created observer: {$lead->id}");
        Log::info("Lead user ID: {$lead->id_user}");
        Log::info("Lead phone: {$lead->phone}");
        
        $this->handleFlowTrigger($lead, 'lead_created');
    }

    public function updated(Lead $lead)
    {
        Log::info("=== LEAD UPDATED OBSERVER ===");
        Log::info("Lead updated: {$lead->id}, status_livrison: {$lead->status_livrison}, status_confirmation: {$lead->status_confirmation}");
        
        if ($lead->wasChanged('status_livrison')) {
            Log::info("Status livrison changed to: {$lead->status_livrison}");
            $this->handleFlowTrigger($lead, 'suivi_status', $lead->status_livrison);
        }
        
        if ($lead->wasChanged('status_confirmation')) {
            Log::info("Status confirmation changed to: {$lead->status_confirmation}");
            $this->handleFlowTrigger($lead, 'confirmation_status', $lead->status_confirmation);
        }
    }

    protected function handleFlowTrigger(Lead $lead, string $triggerType, ?string $status = null)
    {
        Log::info("=== HANDLE FLOW TRIGGER ===");
        Log::info("Trigger type: {$triggerType}, Status: " . ($status ?? 'none'));
        
        $whatsappSettings = WhatsAppSetting::where('user_id', $lead->id_user)->first();
        
        if (!$whatsappSettings) {
            Log::warning("No WhatsApp settings found for user ID: {$lead->id_user}");
            return;
        }
        
        Log::info("WhatsApp settings found: " . ($whatsappSettings->chatbot_enabled ? 'Chatbot enabled' : 'Chatbot disabled'));
        Log::info("Business account ID: {$whatsappSettings->business_account_id}");

        $flowCount = Flow::where('business_account_id', $whatsappSettings->business_account_id)->count();
        Log::info("Total flows for business account: {$flowCount}");

        $flows = Flow::where('business_account_id', $whatsappSettings->business_account_id)
            ->where('is_active', true)
            ->get();

        Log::info("Active flows found: " . $flows->count());

        foreach ($flows as $flow) {
            Log::info("Checking flow: {$flow->id} - {$flow->name}");
            
            $flowData = $flow->flow_data;
            $hasMatchingTrigger = $this->checkFlowTrigger($flowData, $triggerType, $status);
            
            if ($hasMatchingTrigger) {
                Log::info("Flow {$flow->id} matches trigger {$triggerType}");
                $this->processFlow($flow, $lead, $triggerType);
            } else {
                Log::info("Flow {$flow->id} does not match trigger {$triggerType}");
            }
        }
    }

    protected function checkFlowTrigger(array $flowData, string $triggerType, ?string $status): bool
    {
        if (!isset($flowData['nodes'])) {
            Log::info("No nodes found in flow data");
            return false;
        }

        foreach ($flowData['nodes'] as $node) {
            if (($node['type'] ?? '') === 'start') {
                $nodeTriggerType = $node['data']['trigger_type'] ?? '';
                $nodeStatus = $node['data']['selected_status'] ?? null;
                
                Log::info("Node trigger: {$nodeTriggerType}, Node status: " . ($nodeStatus ?? 'none'));
                
                if ($nodeTriggerType === $triggerType) {
                    if ($status && $nodeStatus) {
                        return $status === $nodeStatus;
                    }
                    return true;
                }
            }
        }
        
        return false;
    }

    protected function processFlow(Flow $flow, Lead $lead, string $triggerType)
    {
        Log::info("=== PROCESSING FLOW ===");
        Log::info("Flow ID: {$flow->id}, Flow Name: {$flow->name}");
        
        $flowData = $flow->flow_data;
        
        $startNode = collect($flowData['nodes'])->first(function ($node) use ($triggerType) {
            return ($node['type'] ?? '') === 'start' && 
                   ($node['data']['trigger_type'] ?? '') === $triggerType;
        });

        if (!$startNode) {
            Log::warning("No start node found for trigger: {$triggerType}");
            return;
        }

        Log::info("Start node found:", $startNode);

        if (!isset($startNode['data']['template'])) {
            Log::warning("No template found in start node");
            return;
        }

        $templateData = $startNode['data']['template'];
        Log::info("Template data found:", $templateData);
        
        $this->sendWhatsAppTemplate($lead, $templateData);
    }

    protected function sendWhatsAppTemplate(Lead $lead, array $templateData)
    {
        try {
            $whatsappSettings = WhatsAppSetting::where('user_id', $lead->id_user)->first();
            
            if (!$whatsappSettings) {
                throw new \Exception("WhatsApp settings not found for user {$lead->id_user}");
            }

            $templateName = $templateData['name'] ?? null;
            $templateLanguage = 'en_US'; 

            if (!$templateName) {
                throw new \Exception("Template name not found in flow data");
            }

            $template = WhatsAppMessageTemplate::where('name', $templateName)
                ->where('business_account_id', $whatsappSettings->business_account_id)
                ->first();
                
            $account = WhatsAppBusinessAccount::find($whatsappSettings->business_account_id);

            if (!$template) {
                throw new \Exception("WhatsApp template '{$templateName}' not found");
            }

            $components = $this->prepareTemplateComponents($template, $lead);

            $payload = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $lead->phone,
                'type' => 'template',
                'template' => [
                    'name' => $template->name,
                    'language' => ['code' => $template->language],
                    'components' => $components
                ]
            ];

            Log::info('Sending WhatsApp template payload:', $payload);

            $response = Http::withToken($account->getDecryptedAccessTokenAttribute())
                ->timeout(30)
                ->post("https://graph.facebook.com/v23.0/{$account->phone_number_id}/messages", $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info("WhatsApp template sent successfully to lead {$lead->id}", $responseData);
                
                DeliveryAttempt::create([
                    'lead_id' => $lead->id,
                    'attempted_at' => now(),
                    'customer_answered' => true,
                    'message_type' => 'whatsapp_template',
                    'template_name' => $templateName
                ]);

            } else {
                $errorResponse = $response->json();
                Log::error("Failed to send WhatsApp template to lead {$lead->id}", $errorResponse);
                
                DeliveryAttempt::create([
                    'lead_id' => $lead->id,
                    'attempted_at' => now(),
                    'failed' => true,
                    'failure_reason' => $errorResponse['error']['message'] ?? 'Unknown error',
                    'message_type' => 'whatsapp_template',
                    'template_name' => $templateName
                ]);
            }

        } catch (\Exception $e) {
            Log::error("Error sending WhatsApp template to lead {$lead->id}: " . $e->getMessage());
            
            DeliveryAttempt::create([
                'lead_id' => $lead->id,
                'attempted_at' => now(),
                'failed' => true,
                'failure_reason' => $e->getMessage(),
                'message_type' => 'whatsapp_template'
            ]);
        }
    }

    protected function prepareTemplateComponents(WhatsAppMessageTemplate $template, Lead $lead): array
    {
        $components = [];
        $templateComponents = $template->components ?? [];

        foreach ($templateComponents as $component) {
            if (!isset($component['type'])) continue;

            $parameters = $this->prepareComponentParameters($component, $lead);
            
            if (!empty($parameters)) {
                $components[] = [
                    'type' => strtolower($component['type']),
                    'parameters' => $parameters
                ];
            }
        }

        return $components;
    }

    protected function prepareComponentParameters(array $component, Lead $lead): array
    {
        $parameters = [];
        $componentText = $component['text'] ?? '';

        if (empty($componentText)) {
            return $parameters;
        }

        preg_match_all('/\{\{(\d+)\}\}/', $componentText, $matches);
        
        foreach ($matches[1] as $variableIndex) {
            $variableValue = $this->getVariableValue($variableIndex, $lead, $component['type']);
            
            if ($variableValue) {
                $parameters[] = [
                    'type' => 'text',
                    'text' => $variableValue
                ];
            }
        }

        return $parameters;
    }

    protected function getVariableValue(int $variableIndex, Lead $lead, string $componentType): ?string
    {
        $variableMap = [
            1 => $lead->id, // Lead ID
            2 => $lead->name ?? 'Customer', // Customer Name
            3 => $lead->phone ?? '', // Phone Number
            4 => $lead->email ?? '', // Email
            5 => $this->formatAddress($lead), // Full Address
            6 => $lead->cities[0]->name ?? '', // City
            7 => $lead->country[0]->name ?? '', // Country
            8 => $lead->id_order ?? '', // Order ID
            9 => $lead->n_lead ?? $lead->id_order ?? '', // Order Reference
            10 => $lead->created_at?->format('F j, Y') ?? '', // Order Date
            11 => $lead->delivery_date?->format('F j, Y') ?? 'soon', // Delivery Date
            12 => number_format($lead->amount ?? 0, 2), // Order Total
            13 => ucfirst(str_replace('_', ' ', $lead->status_livrison ?? '')), // Delivery Status
            14 => ucfirst($lead->status_confirmation ?? ''), // Confirmation Status
            15 => ucfirst($lead->payment_method ?? ''), // Payment Method
            16 => $lead->user->email ?? 'Support', // Support Email
            17 => $lead->user->phone ?? '', // Support Phone
            18 => $this->getProductsSummary($lead), // Products Summary
        ];

        $value = $variableMap[$variableIndex] ?? null;

        if ($componentType === 'HEADER' && $variableIndex === 2) {
            $value = $lead->name ? explode(' ', $lead->name)[0] : 'Customer';
        }

        return $value;
    }

    protected function getProductsSummary(Lead $lead): string
    {
        if (!$lead->relationLoaded('products')) {
            $lead->load('products');
        }

        if ($lead->products->isEmpty()) {
            return 'No products';
        }

        $productNames = $lead->products->pluck('name')->toArray();
        return implode(', ', array_slice($productNames, 0, 3)) . 
               ($lead->products->count() > 3 ? '...' : '');
    }

    protected function formatAddress(Lead $lead): string
    {
        $parts = [
            $lead->address,
            $lead->city,
            $lead->zip_code,
            $lead->country[0]->name ?? null
        ];

        return implode(', ', array_filter($parts));
    }
}