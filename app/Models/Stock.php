<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    public function products()
    {
        return $this->hasMany('App\Models\Product' , 'id' ,'id_product');
    }
    
    public function imports()
    {
        return $this->hasMany('App\Models\Import' , 'id' ,'id_import');
    }
    
    public function mapping()
    {
        return $this->hasMany('App\Models\MappingStock' , 'id_stock' ,'id');
    }
}
