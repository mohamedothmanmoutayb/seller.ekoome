<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'metric',
        'current_usage',
        'limit',
        'period_start',
        'period_end'
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function getUsagePercentage()
    {
        if ($this->limit <= 0) return 0;
        return min(100, round(($this->current_usage / $this->limit) * 100));
    }

    public function getRemaining()
    {
        return max(0, $this->limit - $this->current_usage);
    }

    public function isNearLimit($threshold = 0.8)
    {
        if ($this->limit <= 0) return false;
        return ($this->current_usage / $this->limit) >= $threshold;
    }

    public function isOverLimit()
    {
        if ($this->limit <= 0) return false;
        return $this->current_usage > $this->limit;
    }

    public function getStatusColor()
    {
        if ($this->isOverLimit()) return 'danger';
        if ($this->isNearLimit()) return 'warning';
        return 'success';
    }
}