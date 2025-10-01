<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WhatsappAnalyticsController;
use Illuminate\Support\Facades\Log;

class SendWeeklyWhatsappAnalytics extends Command
{
    protected $signature = 'analytics:send-weekly';
    protected $description = 'Send weekly WhatsApp analytics to users who opted in';

    public function handle()
    {
        $controller = new WhatsappAnalyticsController();
        $result = $controller->sendWhatsappAnalytics('weekly');
        
        if ($result && $result->getData()->success) {
            $this->info('Successfully sent weekly WhatsApp analytics');
            Log::info('Successfully sent weekly WhatsApp analytics');
        } else {
            $this->error('Failed to send weekly WhatsApp analytics');
            Log::error('Failed to send weekly WhatsApp analytics');
        }
    }
}