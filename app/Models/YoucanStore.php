<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoucanStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'store_id',
        'slug',
        'is_active',
        'is_email_verified',
        'access_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_email_verified' => 'boolean'
    ];

    public function account()
    {
        return $this->belongsTo(YoucanAccount::class, 'account_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function webhooks()
    {
        return $this->hasMany(YoucanWebhook::class, 'store_id');
    }
}