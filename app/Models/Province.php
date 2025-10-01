<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->Hasone('App\Models\Countrie','id','id_country');
    }
}
