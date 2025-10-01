<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NewNotification implements ShouldBroadcast
{
       use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $userId;

    public function __construct(Notification $notification, $userId)
    {
        $this->notification = $notification;
        $this->userId = $userId;

          Log::info('NewNotification Event constructed with data: ', [
            'userId' => $userId,
            'notification' => $notification
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'NewNotification';
    }
    
    public function broadcastWith()
    {
        Log::info('Event fired');
        return [
            'notification_id' => $this->notification->id,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'type' => $this->notification->type,
            'payload' => json_decode($this->notification->payload),
            'is_read' => $this->notification->is_read,
            'time' => $this->notification->created_at,
        ];
    }
    
}















