<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppMessageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'registered_number_id',
        'business_account_id',
        'message_id',
        'direction',
        'from',
        'to',
        'content',
        'content_type',
        'status',
        'sent_at',
        'delivered_at',
        'read_at',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime'
    ];


    public function registeredNumber()
    {
        return $this->belongsTo(WhatsAppRegisteredNumber::class, 'registered_number_id');
    }


    public function businessAccount()
    {
        return $this->belongsTo(WhatsAppBusinessAccount::class, 'business_account_id');
    }


    public function getDirectionLabelAttribute()
    {
        return match($this->direction) {
            'inbound' => 'Received',
            'outbound' => 'Sent',
            default => ucfirst($this->direction)
        };
    }


    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'sent' => 'info',
            'delivered' => 'primary',
            'read' => 'success',
            'failed' => 'danger',
            default => 'secondary'
        };
    }
}