<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_client_id',
        'external_plan_id',
        'name',
        'description',
        'monthly_price',
        'yearly_price',
        'monthly_price_before_discount',
        'yearly_price_before_discount',
        'users',
        'max_monthly_sales',
        'shipping_companies',
        'deliverymen',
        'stores',
        'agents',
        'sales_channels',
        'products',
        'is_active',
        'type'
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'monthly_price_before_discount' => 'decimal:2',
        'yearly_price_before_discount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function features()
    {
        return $this->hasMany(PlanFeature::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'external_plan_id', 'external_plan_id');
    }
}