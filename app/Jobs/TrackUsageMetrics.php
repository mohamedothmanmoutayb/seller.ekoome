<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Client;
use App\Models\Lead;
use App\Models\UsageTracking;
use App\Models\User;
use App\Models\Sale;

class TrackUsageMetrics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $user = User::find($this->userId);
        
        if (!$user) {
            return;
        }

        $subscription = $user->activeSubscription();
        
        if (!$subscription) {
            return;
        }

        $userCount = User::where('id', "!=", $user->id)->count();
        $this->updateUsage($subscription, 'users', $userCount);

        $currentMonth = now()->format('Y-m');
        $salesCount = Lead::where('id_user', $user->id)
            ->where('created_at', 'like', $currentMonth . '%')
            ->sum('lead_value');

        $this->updateUsage($subscription, 'monthly_sales', $salesCount);

    }

    private function updateUsage($subscription, $metric, $currentUsage)
    {
        UsageTracking::updateOrCreate(
            [
                'user_id' => $subscription->user_id,
                'subscription_id' => $subscription->id,
                'metric' => $metric
            ],
            [
                'current_usage' => $currentUsage,
                'period_start' => $subscription->start_date,
                'period_end' => $subscription->end_date
            ]
        );
    }
}