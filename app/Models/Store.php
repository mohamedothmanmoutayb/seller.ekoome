<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public function ScopeCountProduct($id)
    {
        $id = $this->id;
        $product = Product::where('id_store',$id)->count();
        if($product == 0){
            return  '0';
        }else{
            return $product;
        }
    }

    public function Products()
    {
        return $this->hasMany('App\Models\Product','id_store','id');
    }
}
