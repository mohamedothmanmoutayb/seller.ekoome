<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'customer_answered',
        'attempted_at',
    ];

    protected $table = 'delivery_attempts';


    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
