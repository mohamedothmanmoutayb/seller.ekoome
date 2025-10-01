<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopifyStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'id_country',
        'api_version',
        'store_name',
        'shopify_domain',
        'api_key',
        'admin_api_access_token',
        'webhook_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}