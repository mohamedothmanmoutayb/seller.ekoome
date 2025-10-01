<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use App\Models\Product;
use Auth;

class Warehouse extends Model
{
    use HasFactory;

    public function scopeCountProduct($id)
    {
        $id = $this->id;
        $totalProduct = Import::where('warehouse_id',$id)->where('id_country',Auth::user()->country_id)->select('id_product')->count('id_product');
        if($totalProduct != 0){
            return $totalProduct;
        }else{
            return "0";
        }
        
    }

    public function scopeCountStock($id)
    {
        $id = $this->id;
        $products = Product::where('id_country',Auth::user()->country_id)->where('warehouse_id',$id)->select('id')->get();
        dd($products);
    }
}
