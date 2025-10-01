<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanFeature;
use App\Models\Subscription;
use App\Services\SubscriptionUsageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlanReceiverController extends Controller
{
    public function receivePlans(Request $request)
    {
        Log::info('Received plans data:', $request->all());

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer',
            'client_name' => 'required|string|max:255',
            'client_type' => 'required|string|in:individual,company',
            'plans' => 'required|array',
            'plans.*.id' => 'required|integer',
            'plans.*.name' => 'required|string|max:255',
            'plans.*.description' => 'nullable|string',
            'plans.*.monthly_price' => 'required|numeric|min:0',
            'plans.*.yearly_price' => 'required|numeric|min:0',
            'plans.*.monthly_price_before_discount' => 'nullable|numeric|min:0',
            'plans.*.yearly_price_before_discount' => 'nullable|numeric|min:0',
            'plans.*.users' => 'nullable|string',
            'plans.*.max_monthly_sales' => 'nullable|string',
            'plans.*.shipping_companies' => 'nullable|string',
            'plans.*.deliverymen' => 'nullable|string',
            'plans.*.stores' => 'nullable|string',
            'plans.*.agents' => 'nullable|string',
            'plans.*.sales_channels' => 'nullable|string',
            'plans.*.products' => 'nullable|string',
            'plans.*.is_active' => 'required|boolean',
            'plans.*.type' => 'required|string|in:individual,company',
            'plans.*.features' => 'nullable|array',
            'plans.*.features.*.name' => 'required|string',
            'plans.*.features.*.value' => 'required|string',
            'timestamp' => 'required|date'
        ]);

        if ($validator->fails()) {
            Log::error('Plan validation failed', [
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
            $clientId = $request->client_id;
            $importedCount = 0;
            $updatedCount = 0;

            foreach ($request->plans as $planData) {
                $existingPlan = Plan::where('external_plan_id', $planData['id'])
                    ->where('external_client_id', $clientId)
                    ->first();

                $planDataToSave = [
                    'external_client_id' => $clientId,
                    'external_plan_id' => $planData['id'],
                    'name' => $planData['name'],
                    'description' => $planData['description'] ?? null,
                    'monthly_price' => $planData['monthly_price'],
                    'yearly_price' => $planData['yearly_price'],
                    'monthly_price_before_discount' => $planData['monthly_price_before_discount'] ?? 0,
                    'yearly_price_before_discount' => $planData['yearly_price_before_discount'] ?? 0,
                    'users' => $planData['users'] ?? '0',
                    'max_monthly_sales' => $planData['max_monthly_sales'] ?? '0',
                    'shipping_companies' => $planData['shipping_companies'] ?? '0',
                    'deliverymen' => $planData['deliverymen'] ?? '0',
                    'stores' => $planData['stores'] ?? '0',
                    'agents' => $planData['agents'] ?? '0',
                    'sales_channels' => $planData['sales_channels'] ?? '0',
                    'products' => $planData['products'] ?? '0',
                    'is_active' => $planData['is_active'],
                    'type' => $planData['type']
                ];

                if ($existingPlan) {
                    $existingPlan->update($planDataToSave);
                    $planId = $existingPlan->id;
                    $updatedCount++;
                    
                    PlanFeature::where('plan_id', $planId)->delete();
                } else {
                    $plan = Plan::create($planDataToSave);
                    $planId = $plan->id;
                    $importedCount++;
                }

                if (!empty($planData['features']) && is_array($planData['features'])) {
                    foreach ($planData['features'] as $feature) {
                        PlanFeature::create([
                            'plan_id' => $planId,
                            'name' => $feature['name'],
                            'value' => $feature['value']
                        ]);
                    }
                }
                if ($planData['is_active']) {
                    $subscriptions = Subscription::where('external_plan_id', $planData['id'])
                        ->where('is_active', true)
                        ->get();

                    foreach ($subscriptions as $subscription) {
                        SubscriptionUsageService::updateUsageTrackingForSubscription($subscription);
                    }
                }
            }

            Log::info('Plans imported successfully', [
                'client_id' => $clientId,
                'imported' => $importedCount,
                'updated' => $updatedCount,
                'total_plans' => count($request->plans)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Plans processed successfully',
                'data' => [
                    'imported' => $importedCount,
                    'updated' => $updatedCount,
                    'total_received' => count($request->plans)
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error processing plans', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process plans: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailablePlans(Request $request)
    {
        try {
            $plans = Plan::where('is_active', true)->get();
            
            $currentPlanId = null;
            if ($request->has('subscriber_id')) {
                $subscriber = Subscription::find($request->subscriber_id);
                if ($subscriber) {
                    $currentPlanId = $subscriber->plan_id;
                }
            }
            
            $formattedPlans = $plans->map(function ($plan) use ($currentPlanId) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'description' => $plan->description,
                    'monthly_price' => $plan->monthly_price,
                    'yearly_price' => $plan->yearly_price,
                    'monthly_price_before_discount' => $plan->monthly_price_before_discount,
                    'yearly_price_before_discount' => $plan->yearly_price_before_discount,
                    'users' => $plan->users,
                    'max_monthly_sales' => $plan->max_monthly_sales,
                    'shipping_companies' => $plan->shipping_companies,
                    'deliverymen' => $plan->deliverymen,
                    'stores' => $plan->stores,
                    'agents' => $plan->agents,
                    'sales_channels' => $plan->sales_channels,
                    'products' => $plan->products,
                    'is_current' => $plan->id == $currentPlanId
                ];
            });
            
            return response()->json([
                'success' => true,
                'plans' => $formattedPlans
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch plans: ' . $e->getMessage()
            ], 500);
        }
    }
}