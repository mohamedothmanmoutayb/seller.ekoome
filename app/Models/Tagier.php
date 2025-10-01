<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagier extends Model
{
    use HasFactory;
    
    public function palet()
    {
        return $this->hasOne('App\Models\Palet','id','id_palet');
    }
}
