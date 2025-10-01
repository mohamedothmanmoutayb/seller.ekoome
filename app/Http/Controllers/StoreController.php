<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Countrie;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\ShippingCountrie;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listseller = User::where('id_manager', Auth::user()->id)->select('id')->get()->toarray();
        if(Auth::user()->id_role != "2"){
            $listseller = $listseller;
        }
        $stores = Store::where('id_country', Auth::user()->country_id);
        
        if(Auth::user()->id_role != "2"){
            $stores = $stores->where('id_user',Auth::user()->id);
            $products = Product::where('id_country', Auth::user()->country_id)
                                ->get();
        }else{
            $stores = $stores->where('id_user', Auth::user()->id);
            $products = Product::where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->get();
        }

        if(!empty($request->search)){
            $stores = $stores->where('name','like','%'.$request->search.'%');
        }
        if(!empty($request->product)){
            $product= Product::where('id_country', Auth::user()->country_id)
                                    ->where('id',$request->product)
                                    ->first();
        }
        
        $stores = Store::get();
        // $products = Product::where('id_country', Auth::user()->country_id)
        //                     ->where('id_user', Auth::user()->id)
        //                     ->get();
        return view('backend.stores.index', compact('stores','products'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();
        $data['id_user'] = Auth::user()->id;
        $data['id_country'] = Auth::user()->country_id;
        $data['name'] = $request->name;
        $data['link'] = $request->link;
        if($request->image){
            $file = $request->image;
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('uploads', $filename);
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/'.$filename;
        }else{
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/stores/Shopping bag-amico.svg';
        }
        Store::insert($data);
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store,$id)
    {
        $checkproduct = Product::where('id_store',$id)->get();
        if($checkproduct->isempty()){
            Store::where('id',$id)->delete();
        }
        return back();
    }
    
    public function products(Request $request,$id)
    {
        $products = Product::with(['imports' => function($query){
            $query->where('imports.id_country',Auth::user()->country_id);
        },'stocks','leadpro' => function($query){
            $query = $query->with('leads', function($query){
                $query = $query->where('status_confirmation','confirmed')->whereNotIn('status_livrison',['delivered','canceled','unpacked','returned']);});}
        ])->where('id_store',$id)->where('id_country', Auth::user()->country_id);
        if(Auth::user()->id_role == "2"){
            $products = $products->where('id_user','=', Auth::user()->id);
        }
        $countries = Countrie::get();
        if(!empty($request->search)){
            $products = $products->where('id_user', Auth::user()->id)->where(function ($q) use ($request) {
                $q->where('name','like','%'.$request->search.'%')->orwhere('sku',$request->search);
            });
        }
        if(!empty($request->product_name)){
            $products = $products->where('name','like','%'.$request->product_name.'%');
        }
        if(!empty($request->link)){
            $products = $products->where('link','like','%'.$request->link.'%');
        }
        if(!empty($request->sku)){
            $products = $products->where('sku','like','%'.$request->sku.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 12;
        }
        $products = $products->where('id_country', Auth::user()->country_id)->orderby('id','desc')->paginate($items);//dd($products);
        $productss = Product::where('id_store',$id)->where('id_country', Auth::user()->country_id)->orderby('id','desc')->get();
        $shippincountry = ShippingCountrie::get();
        $stores = Store::where('id_country', Auth::user()->country_id)->get();
        $warehouses = Warehouse::where('country_id',Auth::user()->country_id)->get();
        $suppliers = Supplier::where('country_id',Auth::user()->country_id)->get();

        return view('backend.products.index', compact('products','countries','shippincountry','productss','id','stores','items','warehouses','suppliers'));
    }
}
