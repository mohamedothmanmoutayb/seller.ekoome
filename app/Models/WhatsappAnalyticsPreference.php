<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappAnalyticsPreference extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_analytics_preferences';

    protected $fillable = [
        'user_id',
        'daily',
        'weekly',
        'monthly'
    ];

    protected $casts = [
        'daily' => 'array',
        'weekly' => 'array',
        'monthly' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}