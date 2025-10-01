<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->hasMany('App\Models\Countrie','id','id_country');
    }
}
