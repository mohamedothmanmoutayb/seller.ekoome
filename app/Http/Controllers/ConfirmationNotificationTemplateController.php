t<?php

namespace App\Http\Controllers;

use App\Models\WhatsappConfirmationNotificationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfirmationNotificationTemplateController extends Controller
{
    public function index()
    {
        return view('backend.plugins.confirmationNotification');
    }

    public function getTemplate(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
        ]);
    
        $countryId = auth()->user()->country_id; 
    
        $template = WhatsappConfirmationNotificationTemplate::getTemplate(
            $request->status,
            $countryId
        );
    
        return response()->json([
            'template' => $template ? $template->template : ''
        ]);
    }

    public function saveTemplate(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'template' => 'required|string',
        ]);
    
        $countryId = auth()->user()->country_id; 
    
        try {
            WhatsappConfirmationNotificationTemplate::updateOrCreate(
                [
                    'status' => $request->status,
                    'country_id' => $countryId,
                ],
                [
                    'template' => $request->template,
                ]
            );
    
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
}