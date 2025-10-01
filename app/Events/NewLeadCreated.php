<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLeadCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lead;
    public function __construct($lead)
    {
        $this->lead = $lead;
    }
}