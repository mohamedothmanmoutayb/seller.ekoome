<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsAppRegisteredNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_account_id',
        'phone_number_id',
        'phone_number',
        'display_phone_number',
        'quality_rating',
        'status',
        'certificate',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array'
    ];


    public function businessAccount()
    {
        return $this->belongsTo(WhatsAppBusinessAccount::class, 'business_account_id');
    }


    public function messageLogs()
    {
        return $this->hasMany(WhatsAppMessageLog::class, 'registered_number_id');
    }


    public function getQualityRatingColorAttribute()
    {
        return match($this->quality_rating) {
            'GREEN' => 'success',
            'YELLOW' => 'warning',
            'RED' => 'danger',
            default => 'secondary'
        };
    }
}