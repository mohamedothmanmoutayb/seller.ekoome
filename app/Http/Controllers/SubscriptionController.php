<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
       Log::info('Subscription data received:', $request->all());
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|numeric',
            'plan_name' => 'required|string|max:255',
            'total_price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'debut_date' => 'required|date',
            'fin_date' => 'required|date|after:debut_date',
            'payment_type' => 'required|in:monthly,yearly',
            'is_active' => 'required|boolean',
            'client_id' => 'required|numeric', 
            'subscriber_id' => 'required|numeric', 
            'timestamp' => 'required|date',
        ]);


        if ($validator->fails()) {
            Log::error('Subscription validation failed', [
                'errors' => $validator->errors(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $existingSubscription = Subscription::where('external_subscriber_id', $request->subscriber_id)
                ->first();

            if ($existingSubscription) {
                Log::warning('Subscription already exists', [
                    'external_subscriber_id' => $request->subscriber_id
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription already exists'
                ], 409); 
            }

            $subscription = Subscription::create([
                'external_client_id' => $request->client_id,
                'external_plan_id' => $request->plan_id,
                'plan_name' => $request->plan_name,
                'total_price' => $request->total_price,
                'discount' => $request->discount,
                'start_date' => $request->debut_date,
                'end_date' => $request->fin_date,
                'payment_type' => $request->payment_type,
                'is_active' => $request->is_active,
                'external_subscriber_id' => $request->subscriber_id
            ]);

            Log::info('Subscription created successfully', [
                'subscription_id' => $subscription->id,
                'external_subscriber_id' => $request->subscriber_id,
                'external_client_id' => $request->client_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscription created successfully',
                'subscription_id' => $subscription->id,
                'external_subscriber_id' => $subscription->external_subscriber_id
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating subscription', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create subscription: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkSubscription($subscriberId)
    {
        $subscription = Subscription::where('external_subscriber_id', $subscriberId)
            ->first();

        return response()->json([
            'exists' => !is_null($subscription),
            'subscription' => $subscription
        ]);
    }
}