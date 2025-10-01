<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppBusinessAccount;
use App\Models\WhatsAppRegisteredNumber;
use App\Services\WhatsAppCloudApiService;
use Illuminate\Http\Request;

class WhatsAppNumberController extends Controller
{
    protected $whatsAppService;

    public function __construct()
    {
        $this->whatsAppService = new WhatsAppCloudApiService(config('services.whatsapp.cloud_api_token'));
    }

    /**
     * Register a new phone number
     */
    public function register(Request $request, $accountId)
    {
        $businessAccount = WhatsAppBusinessAccount::findOrFail($accountId);
        
        $validated = $request->validate([
            'phone_number' => 'required|string',
            'display_phone_number' => 'nullable|string'
        ]);

        // Set the access token for this business account
        $this->whatsAppService = new WhatsAppCloudApiService(decrypt($businessAccount->access_token));

        // In a real app, you would call Meta's API to register the number
        // This is a simplified version
        
        $number = WhatsAppRegisteredNumber::create([
            'business_account_id' => $businessAccount->id,
            'phone_number_id' => uniqid('PHONE_'),
            'phone_number' => $validated['phone_number'],
            'display_phone_number' => $validated['display_phone_number'] ?? $validated['phone_number'],
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'number' => $number
        ]);
    }

    /**
     * List all numbers for an account
     */
    public function index($accountId)
    {
        $numbers = WhatsAppRegisteredNumber::where('business_account_id', $accountId)->get();
        return response()->json($numbers);
    }

    /**
     * Get number details
     */
    public function show($accountId, $numberId)
    {
        $number = WhatsAppRegisteredNumber::where('business_account_id', $accountId)
            ->findOrFail($numberId);
            
        return response()->json($number);
    }

    /**
     * Update number details
     */
    public function update(Request $request, $accountId, $numberId)
    {
        $number = WhatsAppRegisteredNumber::where('business_account_id', $accountId)
            ->findOrFail($numberId);
            
        $validated = $request->validate([
            'display_phone_number' => 'sometimes|string',
            'status' => 'sometimes|string'
        ]);

        $number->update($validated);

        return response()->json($number);
    }

    /**
     * Delete a number
     */
    public function destroy($accountId, $numberId)
    {
        $number = WhatsAppRegisteredNumber::where('business_account_id', $accountId)
            ->findOrFail($numberId);
            
        $number->delete();

        return response()->json(['success' => true]);
    }
}