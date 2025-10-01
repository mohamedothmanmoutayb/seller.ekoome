<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappOffersTemplate extends Model
{
    protected $fillable = ['name', 'content', 'country_id'];
}