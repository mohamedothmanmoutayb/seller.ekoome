<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WhatsappAnalyticsController;
use Illuminate\Support\Facades\Log;

class SendMonthlyWhatsappAnalytics extends Command
{
    protected $signature = 'analytics:send-monthly';
    protected $description = 'Send monthly WhatsApp analytics to users who opted in';

    public function handle()
    {
        $controller = new WhatsappAnalyticsController();
        $result = $controller->sendWhatsappAnalytics('monthly');
        
        if ($result && $result->getData()->success) {
            $this->info('Successfully sent monthly WhatsApp analytics');
            Log::info('Successfully sent monthly WhatsApp analytics');
        } else {
            $this->error('Failed to send monthly WhatsApp analytics');
            Log::error('Failed to send monthly WhatsApp analytics');
        }
    }
}