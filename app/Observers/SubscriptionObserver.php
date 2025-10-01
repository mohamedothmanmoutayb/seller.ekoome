<?php

namespace App\Observers;

use App\Models\Subscription;
use App\Models\UsageTracking;
use App\Services\SubscriptionUsageService;

class SubscriptionObserver
{
    public function created(Subscription $subscription)
    {
        if ($subscription->is_active) {
            SubscriptionUsageService::initializeUsageTracking($subscription);
        }
    }

    public function updated(Subscription $subscription)
    {
        if ($subscription->is_active) {
            SubscriptionUsageService::updateUsageTrackingForSubscription($subscription);
        }
    }

    public function deleted(Subscription $subscription)
    {
        UsageTracking::where('subscription_id', $subscription->id)->delete();
    }
}