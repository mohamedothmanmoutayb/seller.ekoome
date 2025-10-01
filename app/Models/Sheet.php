<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;
    
    public function product()
    {
        return $this->hasMany('App\Models\Product' , 'id' ,'id_product');
    }
    
    public function leads()
    {
        return $this->hasOne('App\Models\Lead' , 'id_sheet' ,'id')->orderby('id','desc');
    }
}
