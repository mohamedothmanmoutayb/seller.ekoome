<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WooCommerceWebhook extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_id', 'webhook_id', 'topic', 'status', 'secret'
    ];

    public function integration()
    {
        return $this->belongsTo(WooCommerceIntegration::class);
    }
    
}
