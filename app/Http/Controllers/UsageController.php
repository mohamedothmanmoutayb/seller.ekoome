<?php

namespace App\Http\Controllers;

use App\Jobs\TrackUsageMetrics;
use App\Services\UsageTrackingService;
use Illuminate\Http\Request;

class UsageController extends Controller
{
    public function getUsageMetrics(Request $request)
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            TrackUsageMetrics::dispatch($user->id);

            $usage = UsageTrackingService::getClientUsage($user);
            
            $metrics = [];
            foreach ($usage as $record) {
                $isUnlimited = UsageTrackingService::isUnlimited($record->limit);
                
                $metrics[] = [
                    'metric' => $record->metric,
                    'current_usage' => $record->current_usage,
                    'limit' => $isUnlimited ? 'Unlimited' : $record->limit,
                    'percentage' => $isUnlimited ? 0 : $record->getUsagePercentage(),
                    'remaining' => $isUnlimited ? 'Unlimited' : $record->getRemaining(),
                    'is_over_limit' => $isUnlimited ? false : $record->isOverLimit(),
                    'is_near_limit' => $isUnlimited ? false : $record->isNearLimit(),
                    'is_unlimited' => $isUnlimited
                ];
            }

            return response()->json([
                'success' => true,
                'metrics' => $metrics
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch usage metrics: ' . $e->getMessage()
            ], 500);
        }
    }

    public function incrementUsage(Request $request, $metric)
    {
        try {
            $user = auth()->user(); 
            $amount = $request->input('amount', 1);
            
            $usage = UsageTrackingService::incrementUsage($user, $metric, $amount);
            
            return response()->json([
                'success' => true,
                'message' => 'Usage updated successfully',
                'usage' => [
                    'metric' => $metric,
                    'current_usage' => $usage->current_usage,
                    'limit' => $usage->limit,
                    'remaining' => $usage->getRemaining()
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update usage: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkLimits()
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([]);
        }

        $userLimit = UsageTrackingService::checkLimit($user, 'users');
        $salesLimit = UsageTrackingService::checkLimit($user, 'monthly_sales');

        return response()->json([
            'users' => $userLimit,
            'sales' => $salesLimit,
        ]);
    }
}
