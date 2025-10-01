<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citie extends Model
{
    use HasFactory;
    
    public function country()
    {
        return $this->hasMany('App\Models\Countrie','id','id_country');
    }
    
    public function province()
    {
        return $this->hasOne('App\Models\Province','id','id_province');
    }
    
}
