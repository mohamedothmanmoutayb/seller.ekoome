<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCountrie extends Model
{
    use HasFactory;
    public function countrie()
    {
        return $this->hasMany('App\Models\Countrie,','id','id_countrie');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User','id','id_user');
    }

}
