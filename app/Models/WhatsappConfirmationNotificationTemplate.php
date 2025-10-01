<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappConfirmationNotificationTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'country_id',
        'template'
    ];

    const STATUS_CONFIRMED = 'Confirmed';
    const STATUS_CALLLATER = 'Call later';
    const STATUS_CANCELED = 'Canceled';
    const STATUS_WRONG = 'Wrong';
    const STATUS_DUPLICATED = 'Duplicated';
    const STATUS_OUTOFAREA = 'Out of area';
    const STATUS_NOANSWER = 'No answer';
    const STATUS_OUTOFSTOCK = 'Out of stock';
    const STATUS_ADDTOBLACKLIST = 'Add to blacklist';


    public static function getTemplate($status, $countryId)
    {
        return self::where('status', $status)
                    ->where('country_id', $countryId)
                    ->first();
    }
    
}