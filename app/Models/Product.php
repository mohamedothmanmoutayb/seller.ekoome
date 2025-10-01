<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lead;
use Auth;

class Product extends Model
{
    use HasFactory;
    
    public function users()
    {
        return $this->hasMany('App\Models\User'  ,'id' , 'id_user');
    }
    
    public function imports()
    {
        return $this->hasMany('App\Models\Import'  ,'id_product' , 'id');
    }
    
    public function upselles()
    {
        return $this->hasMany('App\Models\Upsel'  ,'id_product' , 'id');
    }
    
    public function leadpro()
    {
        return $this->hasMany('App\Models\LeadProduct'  ,'id_product' , 'id');
    }
    
    public function stocks()
    {
        return $this->hasMany('App\Models\Stock'  ,'id_product' , 'id');
    }

    public function lead()
    {
        return $this->hasMany('App\Models\Lead', 'id_product', 'id');
    }

    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_products', 'id_product', 'id_lead')
                    ->withPivot('quantity', 'lead_value'); 
    }


    public function stock()
    {
        return $this->hasOne('App\Models\Stock','id_product','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','id_category','id');
    }

    public function Tauxconf($id)
    {
        $total = Lead::where('id_product',$id)->where('id_country',Auth::user()->country_id)->where('id_user',Auth::user()->id)->wherein('status_confirmation',['canceled','confirmed'])->count();
        $confirmed = Lead::where('id_product',$id)->where('id_country',Auth::user()->country_id)->where('id_user',Auth::user()->id)->where('status_confirmation','confirmed')->count();
        if($total != 0){
            $rate = ($confirmed / $total)*100;
        }else{
            $rate = 0;
        }
        
        return number_format($rate, 2, '.', ',');
    }

    public function Tauxdev($id)
    {
        $total = Lead::where('id_product',$id)->where('id_country',Auth::user()->country_id)->where('id_user',Auth::user()->id)->where('status_confirmation','confirmed')->wherein('status_livrison',['return','delivered'])->count();
        $delivered = Lead::where('id_product',$id)->where('id_country',Auth::user()->country_id)->where('id_user',Auth::user()->id)->where('status_confirmation','confirmed')->where('status_livrison','delivered')->count();
        if($total != 0){
            $rate = ($delivered / $total)*100;
        }else{
            $rate = 0;
        }
        
        return number_format($rate, 2, '.', ',');
    }

    public function Revenue($id)
    {
        $revenue = Lead::where('id_product',$id)->where('id_country',Auth::user()->country_id)->where('id_user',Auth::user()->id)->where('status_confirmation','confirmed')->where('status_livrison','delivered')->sum('lead_value');
        return number_format($revenue, 2, '.', ',');
    }

    public function ScopeCountSent($id)
    {
        $stock = Import::where('id_product',$this->id)->sum('quantity_sent');
        if($stock != 0){
            return $stock;
        }else{
            return 0;
        }
    }

    public function ScopeCountStockReal($id)
    {
        $stock = Stock::where('id_product',$this->id)->sum('qunatity');
        if($stock != 0){
            return $stock;
        }else{
            return 0;
        }
    }

    public function ScopeAmountStock($id)
    {
        $product = Product::where('id',$this->id)->first();
        $stock = Stock::where('id_product',$this->id)->sum('qunatity');
        if($stock != 0){
            return $stock * $product->price;
        }else{
            return 0;
        }
    }

    public function upsels()
    {
        return $this->hasMany('App\Models\Upsel', 'id_product', 'id');
    }
}
