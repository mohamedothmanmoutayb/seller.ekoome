<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingPercentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_country',
        'scenario',
        'scenario_type',
        'percentage_upsell',
        'percentage_callcenter',
        'percentage_delivred'
    ];
}
