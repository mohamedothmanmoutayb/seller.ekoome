<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WooCommerceIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'domain', 'consumer_key', 'consumer_secret', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function webhook()
    {
        return $this->hasOne(WooCommerceWebhook::class, 'integration_id');
    }
}
