<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppBusinessAccount;
use App\Models\WhatsAppRegisteredNumber;
use App\Services\WhatsAppCloudApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WhatsAppBusinessAccountController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppCloudApiService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Handle WhatsApp Business registration via embedded signup
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auth_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Exchange auth code for access token
            $tokenResponse = $this->whatsAppService
                ->exchangeAuthCode(
                    $request->auth_code,
                    config('services.facebook.app_id'),
                    config('services.facebook.app_secret'),
                    config('services.facebook.redirect_uri')
                );

            $accessToken = $tokenResponse['access_token'];
            
            $businessAccountId = $this->whatsAppService
                ->setAccessToken($accessToken)
                ->getBusinessAccountIdFromToken();

            if (!$businessAccountId) {
                throw new \Exception('Failed to retrieve business account ID');
            }

            $businessAccount = $this->whatsAppService
                ->setBusinessAccountId($businessAccountId)
                ->getBusinessAccountDetails();

            $waba = WhatsAppBusinessAccount::updateOrCreate(
                ['account_id' => $businessAccountId],
                [
                    'name' => $businessAccount['name'] ?? 'Unknown',
                    'timezone' => $businessAccount['timezone'] ?? 'UTC',
                    'currency' => $businessAccount['currency'] ?? 'USD',
                    'access_token' => encrypt($accessToken),
                    'status' => 'active',
                    'meta_data' => $businessAccount
                ]
            );

            $phoneNumbers = $this->whatsAppService->getPhoneNumbers();
            
            $registeredNumbers = [];
            foreach ($phoneNumbers['data'] ?? [] as $phoneNumber) {
                $registeredNumbers[] = $this->registerPhoneNumber($waba, $phoneNumber);
            }

            return response()->json([
                'success' => true,
                'message' => 'WhatsApp Business account registered successfully',
                'account' => $waba,
                'phone_numbers' => $registeredNumbers
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp registration failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle manual registration of WhatsApp Business account
     */
    public function manualRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_account_id' => 'required|string',
            'phone_number_id' => 'required|string',
            'phone_number' => 'required|string',
            'access_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $accessToken = $request->access_token;
            $businessAccountId = $request->business_account_id;
            $phoneNumberId = $request->phone_number_id;

            $businessAccount = $this->whatsAppService
                ->setAccessToken($accessToken)
                ->setBusinessAccountId($businessAccountId)
                ->getBusinessAccountDetails();

            $waba = WhatsAppBusinessAccount::updateOrCreate(
                ['account_id' => $businessAccountId],
                [
                    'name' => $businessAccount['name'] ?? 'Unknown',
                    'timezone' => $businessAccount['timezone'] ?? 'UTC',
                    'currency' => $businessAccount['currency'] ?? 'USD',
                    'access_token' => encrypt($accessToken),
                    'status' => 'active',
                    'meta_data' => $businessAccount
                ]
            );

            $phoneNumberDetails = $this->whatsAppService
                ->getPhoneNumberDetails($phoneNumberId);

            $registeredNumber = $this->registerPhoneNumber($waba, $phoneNumberDetails, $request->phone_number);

            return response()->json([
                'success' => true,
                'message' => 'WhatsApp Business account registered successfully',
                'account' => $waba,
                'phone_number' => $registeredNumber
            ]);

        } catch (\Exception $e) {
            Log::error('Manual WhatsApp registration failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register a phone number with the business account
     */
    protected function registerPhoneNumber($businessAccount, $phoneNumberData, $phoneNumber = null)
    {
        return WhatsAppRegisteredNumber::updateOrCreate(
            ['phone_number_id' => $phoneNumberData['id']],
            [
                'business_account_id' => $businessAccount->id,
                'phone_number' => $phoneNumber ?? $phoneNumberData['display_phone_number'],
                'display_phone_number' => $phoneNumberData['display_phone_number'] ?? $phoneNumber,
                'quality_rating' => $phoneNumberData['quality_rating'] ?? null,
                'status' => 'active',
                'meta_data' => $phoneNumberData
            ]
        );
    }

    /**
     * Get account details
     */
    public function show($id)
    {
        $number = WhatsAppRegisteredNumber::with('businessAccount')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $number
        ]);
    }

    /**
     * Sync account status with Meta
     */
    public function sync($id)
    {
        $number = WhatsAppRegisteredNumber::with('businessAccount')->findOrFail($id);
        
        try {
            $accessToken = decrypt($number->businessAccount->access_token);
            $phoneNumberId = $number->phone_number_id;

            $phoneNumberDetails = $this->whatsAppService
                ->setAccessToken($accessToken)
                ->getPhoneNumberDetails($phoneNumberId);
            
            $number->update([
                'quality_rating' => $phoneNumberDetails['quality_rating'] ?? null,
                'status' => $phoneNumberDetails['status'] ?? $number->status,
                'meta_data' => $phoneNumberDetails
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Account status synced successfully',
                'data' => $number
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to sync WhatsApp account: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync account status'
            ], 500);
        }
    }

    /**
     * Disconnect account
     */
    public function destroy($id)
    {
        $number = WhatsAppRegisteredNumber::findOrFail($id);
        
        try {
            $number->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp account disconnected successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to disconnect WhatsApp account: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to disconnect account'
            ], 500);
        }
    }
}