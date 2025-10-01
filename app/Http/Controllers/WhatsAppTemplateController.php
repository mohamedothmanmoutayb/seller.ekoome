<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppBusinessAccount;
use App\Models\WhatsAppMessageTemplate;
use App\Services\WhatsAppCloudApiService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WhatsAppTemplateController extends Controller
{
    protected $whatsAppService;

    public function __construct()
    {
        $this->whatsAppService = new WhatsAppCloudApiService(env('WHATSAPP_ACCESS_TOKEN'));
    }

    /**
     * List all templates for an account
     */
    public function index($accountId)
    {
        $businessAccount = WhatsAppBusinessAccount::findOrFail($accountId);
        
        return view('backend.plugins.whatsapp.template.index', [
            'accountId' => $accountId,
            'businessAccount' => $businessAccount
        ]);
    }

    /**
     * Get templates data for DataTables
     */
    public function getTemplatesData($accountId, Request $request)
    {
        $templates = WhatsAppMessageTemplate::where('business_account_id', $accountId)
            ->select(['id', 'name', 'category', 'language', 'status', 'created_at', 'business_account_id']);
        
        return DataTables::of($templates)
            ->filter(function ($query) use ($request) {
                if ($request->has('name') && !empty($request->name)) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                }
                if ($request->has('category') && !empty($request->category)) {
                    $query->where('category', $request->category);
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('status', $request->status);
                }
                if ($request->has('language') && !empty($request->language)) {
                    $query->where('language', $request->language);
                }
            })
            ->make(true);
    }

    /**
     * Get WhatsApp templates data for DataTables
     */
    public function getWhatsAppTemplatesData($accountId)
    {
        $businessAccount = WhatsAppBusinessAccount::findOrFail($accountId);
        
        try {
            $whatsAppTemplates = $this->whatsAppService->getTemplates($businessAccount->account_id);
            
            return DataTables::of($whatsAppTemplates['data'] ?? [])
                ->make(true);
        } catch (\Exception $e) {
            return DataTables::of([])->make(true);
        }
    }

    /**
     * Create a new message template
     */
    
    public function store(Request $request, $accountId)
    {
        $businessAccount = WhatsAppBusinessAccount::findOrFail($accountId);
        $validated = $request->validate([
            'name' => 'required|string|max:512',
            'category' => 'required|string|in:MARKETING,UTILITY,LIMITED-TIME-OFFE,CATALOGUE',
            'language' => 'required|string',
            'header' => 'nullable|string',
            'body' => 'required|string',
            'footer' => 'nullable|string',
            'components' => 'nullable|array',
            'components.*.type' => 'required|string',
            'components.*.format' => 'required_if:components.*.type,HEADER',
            'components.*.text' => 'required_if:components.*.type,BODY,FOOTER',
            'components.*.buttons' => 'required_if:components.*.type,BUTTONS|array|max:3',
            // 'components.*.media_id' => 'required_if:components.*.format,IMAGE,VIDEO,DOCUMENT|nullable|string',
        ]);

        // $this->whatsAppService = new WhatsAppCloudApiService(decrypt($businessAccount->access_token));
        $templateData = [
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'language' => $request->input('language'),
            'components' => $request->input('components') 
        ];

        $template = WhatsAppMessageTemplate::create([
            'business_account_id' => $businessAccount->id,
            'name' => $validated['name'],
            'category' => $validated['category'],
            'language' => $validated['language'],
            'header' => $validated['header'] ?? null,
            'body' => $validated['body'],
            'footer' => $validated['footer'] ?? null,
            'components' => $validated['components'] ?? null,
            'status' => 'draft'
        ]);

        try {
            $response = $this->whatsAppService->registerTemplate(
                $businessAccount->account_id,
                $templateData
            ); 
            
            $template->update([
                'template_id' => $response['id'] ?? null,
                'status' => $response['status'] ?? 'pending',
                'meta' => $response 
            ]);

            return response()->json([
                'success' => true,
                'template' => $template,
                'whatsapp_response' => $response
            ]);
        } catch (\Exception $e) {
            $template->update(['status' => 'failed']);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format components for WhatsApp API
     */
protected function formatComponents($data)
{
    $components = [];

    // Process header - check if header exists in components array first
    $headerComponent = null;
    $mediaHeader = collect($data['components'] ?? [])
        ->firstWhere('type', 'HEADER');

    if ($mediaHeader) {
        // Handle media header from components
        $headerComponent = [
            'type' => 'HEADER',
            'format' => $mediaHeader['format'] ?? 'TEXT'
        ];

        if (isset($mediaHeader['example']['header_handle'])) {
            $headerComponent['example'] = [
                'header_handle' => $mediaHeader['example']['header_handle']
            ];
        } elseif (isset($mediaHeader['example']['header_text'])) {
            $headerComponent['example'] = [
                'header_text' => $mediaHeader['example']['header_text']
            ];
            $headerComponent['text'] = $data['header'] ?? '';
        }
    } elseif (!empty($data['header'])) {
        // Handle text header
        $headerComponent = [
            'type' => 'HEADER',
            'format' => 'TEXT',
            'text' => $data['header']
        ];

        if (!empty($data['header_examples'])) {
            $headerComponent['example'] = [
                'header_text' => $data['header_examples']
            ];
        }
    }

    if ($headerComponent) {
        $components[] = $headerComponent;
    }

    // Process body
    $bodyComponent = [
        'type' => 'BODY',
        'text' => $data['body']
    ];

    $variables = $this->extractBodyVariables($data['body']);
    if (!empty($variables)) {
        $bodyComponent['example'] = [
            'body_text' => [$variables] // Note: this should be array of arrays
        ];
    }

    $components[] = $bodyComponent;

    // Process footer
    if (!empty($data['footer'])) {
        $components[] = [
            'type' => 'FOOTER',
            'text' => $data['footer']
        ];
    }

    // Process buttons and other components
    if (!empty($data['components'])) {
        foreach ($data['components'] as $component) {
            if ($component['type'] === 'BUTTONS' && !empty($component['buttons'])) {
                $buttonsComponent = [
                    'type' => 'BUTTONS',
                    'buttons' => []
                ];
                
                foreach ($component['buttons'] as $button) {
                    $buttonData = [
                        'type' => strtoupper($button['type'])
                    ];
                    
                    if (in_array($button['type'], ['quick_reply', 'url', 'phone_number', 'catalog', 'copy_code'])) {
                        $buttonData['text'] = $button['text'];
                        
                        if ($button['type'] === 'url') {
                            $buttonData['url'] = $button['url'];
                            $buttonData['example'] = [$button['url']];
                        } elseif ($button['type'] === 'phone_number') {
                            $buttonData['phone_number'] = $button['phone_number'];
                        } elseif ($button['type'] === 'copy_code') {
                            $buttonData['example'] = [$button['example'] ?? 'COUPON123'];
                        }
                        
                        $buttonsComponent['buttons'][] = $buttonData;
                    }
                }
                
                if (!empty($buttonsComponent['buttons'])) {
                    $components[] = $buttonsComponent;
                }
            }
        }
    }

    return $components;
}

    /**
     * Extract variables from body text for example data
     */
protected function extractBodyVariables($bodyText)
{
    preg_match_all('/\{\{(\d+)\}\}/', $bodyText, $matches);
    
    $examples = [];
    foreach ($matches[1] as $varNumber) {
        $examples[] = "Sample value $varNumber";
    }
    
    return $examples;
}   

    /**
     * Get template details
     */
    public function show($accountId, $templateId)
    {
        $template = WhatsAppMessageTemplate::where('business_account_id', $accountId)
            ->findOrFail($templateId);
            
        return response()->json($template);
    }

    /**
     * Delete a template
     */
    public function destroy($accountId, $templateId)
    {
        $businessAccount = WhatsAppBusinessAccount::findOrFail($accountId);
        $template = WhatsAppMessageTemplate::where('business_account_id', $accountId)
            ->findOrFail($templateId);
            
        try {
            if ($template->status === 'approved') {
                $response = $this->whatsAppService->deleteTemplate(
                    $businessAccount->account_id,
                    $template->name
                );
            }
            
            $template->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Template deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkDestroy($accountId, Request $request)
    {
        $templateIds = $request->input('template_ids', []);
        $businessAccount = WhatsAppBusinessAccount::findOrFail($accountId);
        $deletedCount = 0;
        $errors = [];

        foreach ($templateIds as $templateId) {
            try {
                $template = WhatsAppMessageTemplate::where('business_account_id', $accountId)
                    ->findOrFail($templateId);

                if ($template->status === 'approved') {
                    $this->whatsAppService->deleteTemplate(
                        $businessAccount->account_id,
                        $template->name
                    );
                }
                
                $template->delete();
                $deletedCount++;
            } catch (\Exception $e) {
                $errors[] = "Failed to delete template ID {$templateId}: " . $e->getMessage();
            }
        }

        if (count($errors)) {
            return response()->json([
                'success' => false,
                'error' => 'Some templates could not be deleted.',
                'details' => $errors
            ], 207); 
        };

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} template(s) deleted successfully."
        ]);
    }

    public function create($accountId)
    {
        $businessAccount = WhatsAppBusinessAccount::findOrFail($accountId);
        
        return view('backend.plugins.whatsapp.template.create', [
            'businessAccount' => $businessAccount,
            'accountId' => $accountId
        ]);
    }
}