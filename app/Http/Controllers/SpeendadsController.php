<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SpeendAd;
use App\Models\ProductSpend;
use App\Models\DetailSpennd;
use App\Models\SpeendProduct;
use App\Models\SocialMedias;
use Illuminate\Http\Request;
use Auth;

class SpeendadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $speends = SpeendAd::where('country_id',Auth::user()->country_id)->where('user_id',Auth::user()->id);
        if($request->platform_speend){
            $speends = $speends->where('platform', $request->platform_speend);
        }
        if($request->date){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_from == $date_two){
                $speends = $speends->whereDate('created_at','=',$date_from);
            }else{
                $speends = $speends->whereDate('date','<=',$date_from)->whereDate('date','>=',$date_two);
            }
        }
        
        $speends = $speends->orderby('id','desc')->paginate(10);
        $medias = SocialMedias::where('status',1)->get();
        
        return view('backend.speends.index',compact('speends','medias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function speend(Request $request,$id)
    {
        $speends = SpeendAd::where('country_id',Auth::user()->country_id)->where('user_id',Auth::user()->id)->where('platform',$id);
        if($request->platform_speend){
            $speends = $speends->where('id_product_spend', $request->platform_speend);
        }
        if($request->date){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_from == $date_two){
                $speends = $speends->whereDate('created_at','=',$date_from);
            }else{
                $speends = $speends->whereDate('date','<=',$date_from)->whereDate('date','>=',$date_two);
            }
        }
        
        $speends = $speends->orderby('id','desc')->paginate(10);
        
        return view('backend.speends.speend',compact('speends'));
    }

    public function product(Request $request,$id)
    {
        $products = Product::where('id_country',Auth::user()->country_id)->get();

        $productspends = ProductSpend::with('product')->where('country_id',Auth::user()->country_id)->where('id_platform',$id);
        
        if($request->date){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            if(empty($parts[1])){
                $productspends = $productspends->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
            }else{
                $date_two = $parts[1];
                if($date_two == $date_from){
                    $productspends = $productspends->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
                }else{
                    $productspends = $productspends->whereBetween('created_at', [date('Y-m-d' , strtotime($date_from)) , date('Y-m-d' , strtotime($date_two))]);
                }
            }
        }
        if($request->product_id){
            $productspends = $productspends->where('id_product',$request->product_id);
        }
        $productspends = $productspends->paginate(10);

        return view('backend.speends.product', compact('productspends','products','id'));

    }

    public function productstore(Request $request)
    {
        $data = array();
        $data['country_id'] = Auth::user()->country_id;
        $data['id_platform'] = $request->platform_speend;
        $data['id_product'] = $request->product_id;

        ProductSpend::insert($data);

        return back();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();
        $data['country_id'] = Auth::user()->country_id;
        $data['user_id'] = Auth::user()->id;
        $data['id_product_spend'] = $request->chaneel_product;
        $data['date'] = $request->date_speend;
        $data['amount'] = $request->amount_speend;
        $data['note'] = $request->note_speend;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        SpeendAd::insert($data);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Speendad  $speendad
     * @return \Illuminate\Http\Response
     */
    public function show(Speendad $speendad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Speendad  $speendad
     * @return \Illuminate\Http\Response
     */
    public function edit(Speendad $speendad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speendad  $speendad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speendad $speendad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speendad  $speendad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speendad $speendad)
    {
        //
    }

    public function details(Request $request,$id)
    {
        $speends = SpeendAd::where('id_product_spend',$id);
        if($request->date){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            if(empty($parts[1])){
                $speends = $speends->whereDate('date','=',date('Y-m-d' , strtotime($date_from)));
            }else{
                $date_two = $parts[1];
                if($date_two == $date_from){
                    $speends = $speends->whereDate('date','=',date('Y-m-d' , strtotime($date_from)));
                }else{
                    $speends = $speends->whereBetween('date', [date('Y-m-d' , strtotime($date_from)) , date('Y-m-d' , strtotime($date_two))]);
                }
            }
        }
        $speends = $speends->orderby('id','desc')->paginate(10);
        return view('backend.speends.pack', compact('speends','id'));
    }
}
