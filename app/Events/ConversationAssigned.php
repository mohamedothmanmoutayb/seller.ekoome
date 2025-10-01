<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ConversationAssignment;

class ConversationAssigned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $assignment;

    /**
     * Create a new event instance.
     */
    public function __construct(ConversationAssignment $assignment)
    {
        $this->assignment = $assignment->load(['assignedTo', 'assignedBy', 'conversation']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast to the assigned agent's private channel
        return [
            new PrivateChannel('user.' . $this->assignment->assigned_to),
            new PrivateChannel('conversation.' . $this->assignment->conversation_id)
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'conversation.assigned';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'assignment' => [
                'id' => $this->assignment->id,
                'conversation_id' => $this->assignment->conversation_id,
                'assigned_to' => [
                    'id' => $this->assignment->assignedTo->id,
                    'name' => $this->assignment->assignedTo->name,
                    'role' => $this->assignment->assignedTo->role,
                ],
                'assigned_by' => [
                    'id' => $this->assignment->assignedBy->id,
                    'name' => $this->assignment->assignedBy->name,
                ],
                'reason' => $this->assignment->reason,
                'priority' => $this->assignment->priority,
                'is_manager_assigned' => $this->assignment->is_manager_assigned,
                'assigned_at' => $this->assignment->assigned_at->toISOString(),
            ],
            'conversation' => [
                'id' => $this->assignment->conversation->id,
                'contact_name' => $this->assignment->conversation->contact_name,
                'contact_number' => $this->assignment->conversation->contact_number,
            ]
        ];
    }
}