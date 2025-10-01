<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client;
use App\Jobs\TrackUsageMetrics;
use App\Models\User;

class PopulateUsageData extends Command
{
    protected $signature = 'usage:populate 
                            {--user= : Populate for specific client ID}
                            ';
    
    protected $description = 'Populate usage tracking data with actual usage';

    public function handle()
    {
        if ($this->option('user')) {
            $user = User::find($this->option('user'));
            
            if (!$user) {
                $this->error("User not found.");
                return 1;
            }

            TrackUsageMetrics::dispatchSync($user->id);
            $this->info("Usage data populated for user: " . $user->id);
            
            return 0;
        }

        $this->error("Please specify either --client=ID option");
        return 1;
    }
}