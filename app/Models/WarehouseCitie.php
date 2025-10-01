<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseCitie extends Model
{
    use HasFactory;

    public function City()
    {
        return $this->hasOne('App\Models\Citie','id','city_id');
    }
}
