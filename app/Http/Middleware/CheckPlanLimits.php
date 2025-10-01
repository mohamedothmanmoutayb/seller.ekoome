<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use App\Models\UsageTracking;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $metric): Response
    {
        $user = auth()->user(); 

        if (!$user) {
            return $next($request);
        }

        $subscription = Subscription::where('user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        if (!$subscription) {
            return $next($request);
        }

        $usage = UsageTracking::where('user_id', $user->id)
            ->where('subscription_id', $subscription->id)
            ->where('metric', $metric)
            ->where('period_start', '<=', now())
            ->where('period_end', '>=', now())
            ->first();

        if ($usage && $usage->isOverLimit()) {
            return response()->json([
                'error' => 'Plan limit exceeded',
                'message' => "You have exceeded your {$metric} limit for the current billing period.",
                'metric' => $metric,
                'current_usage' => $usage->current_usage,
                'limit' => $usage->limit
            ], 403);
        }

        return $next($request);
    }
}
