<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Services\SubscriptionUsageService;

class InitializeUsageTracking extends Command
{
    protected $signature = 'usage-tracking:initialize 
                            {--subscription= : Initialize specific subscription ID}
                            {--all : Initialize all active subscriptions}';
    
    protected $description = 'Initialize usage tracking for subscriptions';

    public function handle()
    {
        if ($this->option('subscription')) {
            $subscription = Subscription::find($this->option('subscription'));
            
            if (!$subscription) {
                $this->error("Subscription not found.");
                return 1;
            }

            if (SubscriptionUsageService::initializeUsageTracking($subscription)) {
                $this->info("Usage tracking initialized for subscription: " . $subscription->id);
            } else {
                $this->error("Failed to initialize usage tracking for subscription: " . $subscription->id);
            }
            
            return 0;
        }

        if ($this->option('all')) {
            $this->info("Initializing usage tracking for all active subscriptions...");
            
            $count = SubscriptionUsageService::initializeAllSubscriptions();
            
            $this->info("Successfully initialized usage tracking for {$count} subscriptions.");
            return 0;
        }

        $this->error("Please specify either --subscription=ID or --all option");
        return 1;
    }
}