<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Lead extends Model
{
    use HasFactory;
    
    protected $fillable = [
    "n_lead",
    "name",
    "note",
    "id_city",
    "city",
    "address",
    "phone",
    "phone2",
    "quantity",
    "lead_value",
    "created_at",
    "delivered_at",
    "id_user",
    "id_country",
    "market",
    "method_payment",
    "id_product",
    "id_assigned",
    "id_zone",
    "discount"
];

    
    public function country()
    {
        return $this->hasMany('App\Models\Countrie','id','id_country');
    }
    
    public function cities()
    {
        return $this->hasMany('App\Models\Citie','id','id_city');
    }
    
    public function zones()
    {
        return $this->hasMany('App\Models\Zone','id','id_zone');
    }
    
    public function product()
    {
        return $this->hasMany('App\Models\Product','id','id_product');
    }
    
    public function leadproduct()
    {
        return $this->hasMany(LeadProduct::class, 'id_lead', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'lead_products', 'id_lead', 'id_product')
                    ->withPivot('quantity', 'lead_value'); 
    }

    public function leadproducts()
    {
        return $this->hasMany('App\Models\Product','id','id_product');
    }
    
    public function leadbyvendor()
    {
        return $this->hasMany('App\Models\User','id','id_user');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    
    public function delivery()
    {
        return $this->hasMany('App\Models\User','id','livreur_id');
    }
    
    public function leadpro()
    {
        return $this->hasOne('App\Models\LeadProduct','id_lead','id')->where('isupsell','0');
    }
    
    public function livreur()
    {
        return $this->hasOne('App\Models\User','id','livreur_id');
    }

    public function historystatu()
    {
        return $this->hasMany('App\Models\HistoryStatu','id_lead','id');
    }

    public function leadinvoi()
    {
        return $this->hasone('App\Models\LeadInvoice','id_lead','id');
    }

    public function stock()
    {
        return $this->hasone('App\Models\Stock','id_product','id_product');
    }

    public function seller()
    {
        return $this->hasone('App\Models\User','id','id_user');
    }

    public function whatsappStatus()
    {
        return $this->hasOne(WhatsappStatus::class);
    }

    public function deliveryattempts()
    {
        return $this->hasMany(DeliveryAttempt::class, 'lead_id');
    }

    public function ScopeCountDelivered($query, $id , $date_from , $date_two)
    {
        if($date_from == $date_two){
            return Lead::where('id_assigned',$id)->where('status_confirmation','confirmed')->where('status_livrison','delivered')->where('id_country', auth()->user()->country_id)->whereDate('date_confirmed',$date_from)->count();
        }else{
            return Lead::where('id_assigned',$id)->where('status_confirmation','confirmed')->where('status_livrison','delivered')->where('id_country', auth()->user()->country_id)->whereBetween('date_confirmed',[$date_from , $date_two])->count();
        }
        
    }

    public function scopeListOforder($query,$id)
    {
        $lead = Lead::where('id',$id)->first();
        $count = Lead::where('phone',$lead->phone)->where('deleted_at',0)->count();

        return $count;
    }

    public function ScopeQuanityDelivered($query , $date_1_call , $date_2_call , $agent , $quantity)
    {
        $check = Lead::where('id_assigned',$agent)->where('quantity',$quantity)->where('status_confirmation','confirmed')->where('status_livrison','delivered');
        if($date_1_call == $date_2_call){
            $check = $check->where('date_confirmed',date('Y-m-d', strtotime($date_1_call)));
        }else{
            $check = $check->where('date_confirmed','>=',date('Y-m-d', strtotime($date_1_call)))->where('date_confirmed','<=',date('Y-m-d', strtotime($date_2_call)));
        }
        $check = $check->groupby('lead_value')->select(DB::raw('count(id) as count'),'lead_value')->get();

        return $check;
    }

    public function ScopePriceConfirmed($query , $date_1_call , $date_2_call , $agent , $quantity)
    {
        $check = Lead::where('id_assigned',$agent)->where('quantity',$quantity)->where('status_confirmation','confirmed');
        if($date_1_call == $date_2_call){
            $check = $check->where('date_confirmed',date('Y-m-d', strtotime($date_1_call)));
        }else{
            $check = $check->where('date_confirmed','>=',date('Y-m-d', strtotime($date_1_call)))->where('date_confirmed','<=',date('Y-m-d', strtotime($date_2_call)));
        }
        $check = $check->groupby('lead_value')->select(DB::raw('count(id) as count'),'lead_value')->get();

        return $check;
    }
    public function ScopeLeadCount($query , $type , $city , $date , $market , $product)
    {
        $lead  = Lead::where('id_user',Auth::user()->id);
        if($type){
            $lead = $lead->where('status_confirmation','LIKE','%'.$type.'%');
        }
        if($product){
            $lead = $lead->where('id_product',$product);
        }
        if($date){
            $parts = explode(' - ' , $date);
            $date_from = $parts[0];
            if(empty($parts[1])){
                $lead = $lead->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
            }else{
                $date_two = $parts[1];
                if($date_two == $date_from){
                    $lead = $lead->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
                }else{
                    $lead = $lead->whereDate('leads.created_at','>=',date('Y-m-d' , strtotime($date_from)))->whereDate('leads.created_at','<=',date('Y-m-d' , strtotime($date_two)));
                }
            }
        }
        if($market){
            $lead = $lead->where('market',$market);
        }
        $lead = $lead->where('deleted_at',0)->count();
        return $lead;
    }

    public function ScopeOrderCount($query , $type , $city , $date , $market , $product)
    {
        $lead  = Lead::where('id_user',Auth::user()->id)->where('status_confirmation','confirmed');
        if($type){
            $lead = $lead->where('status_livrison','LIKE','%'.$type.'%');
        }
        if($product){
            $lead = $lead->where('id_product',$product);
        }
        if($date){
            $parts = explode(' - ' , $date);
            $date_from = $parts[0];
            if(empty($parts[1])){
                $lead = $lead->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
            }else{
                $date_two = $parts[1];
                if($date_two == $date_from){
                    $lead = $lead->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
                }else{
                    $lead = $lead->whereDate('leads.created_at','>=',date('Y-m-d' , strtotime($date_from)))->whereDate('leads.created_at','<=',date('Y-m-d' , strtotime($date_two)));
                }
            }
        }
        if($market){
            $lead = $lead->where('market',$market);
        }
        $lead = $lead->where('deleted_at',0)->count();
        return $lead;
    }

}
