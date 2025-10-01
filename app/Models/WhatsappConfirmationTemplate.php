<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappConfirmationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'country_id',
        'template',
        'buttons',
        'editable_fields' 
    ];

    protected $casts = [
        'buttons' => 'array',
        'editable_fields' => 'array'
    ];

    const STATUS_CONFIRMATION = 'Order Confirmation Message';
    const STATUS_CLIENT_INFORMATIONS = 'Client Informations Message';


    const EDITABLE_FIELDS = [
        'customer-name',
        'customer-phone',
        'customer-email',
        'customer-address',
        'customer-city'
    ];


    public static function getTemplate($status, $country_id)
    {
        return self::where('status', $status)
                   ->where('country_id', $country_id)
                   ->first();
    }
}
