<?php

namespace App\Http\Controllers;

use App\Http\Services\WhatsAppService;
use App\Models\Client;
use App\Models\Communication;
use App\Models\Countrie;
use App\Models\Lead;
use App\Models\Product;
use App\Models\WhatsAppAccount;
use App\Models\WhatsappOffersTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationOffersController extends Controller
{
    public function index()
    {
        $templates = WhatsappOffersTemplate::where('country_id', auth()->user()->country_id)
            ->orderBy('name')
            ->get();

        return view('backend.plugins.offers', compact('templates'));
    }

    public function getTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
    
        $template = WhatsappOffersTemplate::where('name', $request->name)
            ->where('country_id', auth()->user()->country_id)
            ->first();
    
        return response()->json([
            'template' => $template ? $template->content : '',
        ]);
    }
    
    public function saveTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'template' => 'required|string',
        ]);
        
        try {
            $template = WhatsappOffersTemplate::where('name', $request->name)
                ->where('country_id', auth()->user()->country_id)
                ->first();
            
            if (!$template) {
                $template = new WhatsappOffersTemplate();
                $template->name = $request->name;
                $template->country_id = auth()->user()->country_id;
            }
            
            $template->content = $request->template;
            $template->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Template saved successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving template: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save template'
            ], 500);
        }
    }

    public function sendBulkOffers(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:whatsapp_offers_templates,id',
            'whatsapp_account_id' => 'required|exists:whatsapp_accounts,id',
            'lead_ids' => 'required'
        ]);

        $leadIds = explode(',', $request->lead_ids);
        $template = WhatsappOffersTemplate::findOrFail($request->template_id);
        $whatsappAccount = WhatsAppAccount::findOrFail($request->whatsapp_account_id);
        
        $sentCount = 0;
        $failedCount = 0;

        
        foreach ($leadIds as $leadId) {
            try {
                $lead = Lead::findOrFail($leadId);
                $client = $lead->client; 

                
                $message = $template->content;
                
                foreach ($request->except(['_token', 'template_id', 'whatsapp_account_id', 'lead_ids']) as $key => $value) {
                    $message = str_replace("{{ $key }}", $value, $message);
                }
                
                $message = str_replace("{{ customer-name }}", $client->name, $message);
                $message = str_replace("{{ customer-phone }}", $client->phone1, $message);

                $whatsappService = new WhatsAppService();
                $response = $whatsappService->sendMessage(
                    $whatsappAccount->instance_id,
                    $whatsappAccount->token,
                    $lead->phone,
                    $message
                );
                
                if ($response['sent'] === 'true') {
                    $sentCount++;
                } else {
                    $failedCount++;
                }
                
            } catch (\Exception $e) {
                $failedCount++;
                Log::error("Failed to send offer to lead {$leadId}: " . $e->getMessage());
            }
        }
        
        return response()->json([
            'success' => true,
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
            'message' => "Offers sent to {$sentCount} leads, failed for {$failedCount} leads"
        ]);
    }
    
    public function createNewTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:whatsapp_offers_templates,name,NULL,id,country_id,' . auth()->user()->country_id,
        ]);
        
        try {
            WhatsappOffersTemplate::create([
                'name' => $request->name,
                'country_id' => auth()->user()->country_id,
                'content' => ''
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'New template created successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating new template: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create new template'
            ], 500);
        }
    }

    public function getTemplateDetails(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:whatsapp_offers_templates,id',
        ]);
    
        $template = WhatsappOffersTemplate::where('id', $request->id)
            ->where('country_id', auth()->user()->country_id)
            ->first();
    
        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'template' => $template->content,
            'raw_template' => $template->content
        ]);
    }

    public function sendOffer(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'template_id' => 'required|exists:whatsapp_offers_templates,id',
            'phone' => 'required',
        ]);

        try {
            $client = Client::findOrFail($request->client_id);
            $template = WhatsappOffersTemplate::where('id', $request->template_id)
                ->where('country_id', auth()->user()->country_id)
                ->firstOrFail();
            
            $message = $template->content;
            
            foreach ($request->except(['_token', 'client_id', 'template_id', 'phone']) as $key => $value) {
                $message = str_replace("{{ $key }}", $value, $message);
            }


            $country = Countrie::findOrFail($client->id_country);
            $phone = preg_replace('/[^0-9]/', '', $request->phone);
            
            if (preg_match('/^(06|07)/', $phone)) {
                $phone = $country->negative_ultra . substr($phone, 1);
            }

            $whatsappAccount = WhatsAppAccount::where('id', $request->whatsapp_account_id)
                ->where('country_id', $client->id_country)
                ->where('status', 'active')
                ->firstOrFail();
            
            $instanceId = $whatsappAccount->instance_id;
            $token = $whatsappAccount->token;
            

            $whatsappService = new WhatsAppService();
        
            $response = $whatsappService->sendMessage(
                $instanceId,
                $token,
                $phone,
                $message
            );
            
            // if ($request->product_id) {
            //     $product = Product::find($request->product_id);
            //     if ($product) {
            //         $message .= "\n\nProduct: {$product->name}";
            //         $message .= "\nPrice: {$product->price} DH";
            //         if ($product->image) {
            //             $message .= "\nImage: " . url($product->image);
            //         }
            //     }
            // }
            if ($response['sent'] === 'true' && $response['message'] === 'ok') {
                return response()->json([
                    'success' => true,
                    'message' => 'Offer sent successfully',
                    // 'message_id' => $response['id'] 
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send offer',
                    'error' => $response['message'] ?? 'Unknown error'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error sending offer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send offer'
            ], 500);
        }
    }

    public function deleteTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|exists:whatsapp_offers_templates,name,country_id,' . auth()->user()->country_id,
        ]);

        try {
            WhatsappOffersTemplate::where('name', $request->name)
                ->where('country_id', auth()->user()->country_id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Template deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting template: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete template'
            ], 500);
        }
    }
}