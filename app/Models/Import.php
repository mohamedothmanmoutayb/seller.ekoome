<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;
    
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'id' ,'id_product');
    }
    
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'id' ,'id_product');
    }
    
    public function countries()
    {
        return $this->hasMany('App\Models\Countrie', 'id' ,'id_country');
    }
    
    public function shipping()
    {
        return $this->hasMany('App\Models\ShippingCountrie', 'id' ,'shipping_country');
    }
}
