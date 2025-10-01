<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappNotificationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'country_id',
        'template'
    ];

    const STATUS_UNPACKED = 'Unpacked';
    const STATUS_PICKING = 'Picking process';
    const STATUS_PACKED = 'Item packed';
    const STATUS_SHIPPED = 'Shipped';
    const STATUS_TRANSIT = 'In transit';
    const STATUS_DELIVERY = 'In delivery';
    const STATUS_PROCESSING = 'Processing';
    const STATUS_DELIVERED = 'Delivered';
    const STATUS_INCIDENT = 'Incident';
    const STATUS_REJECTED = 'Rejected';
    const STATUS_RETURNED = 'Returned';


    public static function getTemplate($status, $countryId)
    {
        return self::where('status', $status)
                    ->where('country_id', $countryId)
                    ->first();
    }
    
}