<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    protected $fillable = [
        'name',
        'business_account_id',
        'flow_data',
        'is_active'
    ];

    protected $casts = [
        'flow_data' => 'array',
        'is_active' => 'boolean'
    ];

    public function businessAccount()
    {
        return $this->belongsTo(WhatsAppBusinessAccount::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}