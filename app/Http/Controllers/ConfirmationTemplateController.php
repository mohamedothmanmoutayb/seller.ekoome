<?php

namespace App\Http\Controllers;

use App\Models\WhatsappConfirmationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ConfirmationTemplateController extends Controller
{
    public function index()
    {
        return view('backend.plugins.confirmation');
    }

    public function saveTemplate(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'template' => 'required|string',
            'buttons' => 'nullable|array', 
            'buttons.*' => 'string|max:20',
            'editable_fields' => 'nullable|array'
        ]);

        try {
            $countryId = Auth::user()->country_id; 

            WhatsappConfirmationTemplate::updateOrCreate(
                [
                    'status' => $request->status,
                    'country_id' => $countryId,
                ],
                [
                    'template' => $request->template,
                    'buttons' => $request->buttons ? json_encode($request->buttons) : null,
                    'editable_fields' => $request->editable_fields ? json_encode($request->editable_fields) : null
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

    public function getTemplate(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
        ]);
    
        $countryId = Auth::user()->country_id;
    
        $template = WhatsappConfirmationTemplate::getTemplate(
            $request->status,
            $countryId
        );
    
        return response()->json([
            'template' => $template ? $template->template : '',
            'buttons' => $template && $template->buttons ? json_decode($template->buttons) : [],
            'editable_fields' => $template && $template->editable_fields ? json_decode($template->editable_fields) : []
        ]);
    }
}