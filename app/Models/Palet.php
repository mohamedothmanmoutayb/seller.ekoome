<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Palet extends Model
{
    use HasFactory; 
    
    
    public function row()
    {
        return $this->hasOne('App\Models\Row','id','id_row');
    }
}
