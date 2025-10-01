<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chatbot_enabled',
        'active_languages',
    ];

    protected $table = 'whatsapp_settings';

    protected $casts = [
    'active_chats' => 'array',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
