<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'assigned_to',
        'assigned_by',
        'reason',
        'priority',
        'is_manager_assigned',
        'assigned_at',
        'resolved_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime',
        'is_manager_assigned' => 'boolean'
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function conversation()
    {
        return $this->belongsTo(WhatsAppConversation::class, 'conversation_id');
    }
}