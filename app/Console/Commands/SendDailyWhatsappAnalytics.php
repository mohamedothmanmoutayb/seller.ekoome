<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WhatsappAnalyticsController;
use Illuminate\Support\Facades\Log;

class SendDailyWhatsappAnalytics extends Command
{
    protected $signature = 'analytics:send-daily';
    protected $description = 'Send daily WhatsApp analytics to users who opted in';

    public function handle()
    {
        $controller = new WhatsappAnalyticsController();
        $result = $controller->sendWhatsappAnalytics('daily');
        
        if ($result && $result->getData()->success) {
            $this->info('Successfully sent daily WhatsApp analytics');
            Log::info('Successfully sent daily WhatsApp analytics');
        } else {
            $this->error('Failed to send daily WhatsApp analytics');
            Log::error('Failed to send daily WhatsApp analytics');
        }
    }
}