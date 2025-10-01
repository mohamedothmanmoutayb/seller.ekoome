<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Citie;
use App\Models\Import;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\WarehouseCitie;
use Auth;
use DateTime;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::where('country_id',Auth::user()->country_id)->paginate(10);
        return view('backend.warehouses.index', compact('warehouses'));
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
        $data['country_id'] = Auth::user()->country_id;
        $data['name'] = $request->name_warehouse;
        $data['city'] = $request->city;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        if(!empty($request->islastmille)){
            $data['is_lastmille'] = "1";
        }
        $data['created_at'] = new DateTime();
        //dump($request->hasFile('imaage'));
        if($request->image_product){
            $file = $request->image_product;
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('uploads', $filename);
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/'.$filename;
        }else{
            $data['image'] = 'https://www.'.request()->server->get('SERVER_NAME').'/uploads/warehouse/Checking boxes-rafiki.svg';
        }
        Warehouse::insert($data);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }

    public function overview(Request $request,$id)
    {
        $imports = Import::where('warehouse_id',$id)->where('id_country',Auth::user()->country_id)->get();
        $prosuctimport = Import::where('warehouse_id',$id)->where('id_country',Auth::user()->country_id)->select('id_product')->get();
        $products = Product::wherein('id',$prosuctimport)->get();

        $orders = Lead::where('warehouse_id',$id)->get();
        $orderstotal = Lead::where('warehouse_id',$id)->count();
        $ordersdelivered = Lead::where('warehouse_id',$id)->where('status_livrison','delivered')->count();
        $ordersreturned = Lead::where('warehouse_id',$id)->wherein('status_livrison',['returned','rejected'])->count();

        $revenues = Lead::where('warehouse_id',$id)->where('status_livrison','delivered')->sum('lead_value');

        return view('backend.warehouses.overview', compact('imports','products','orders','ordersdelivered','ordersreturned','orderstotal','revenues'));
    }

    public function cities($id)
    {
        $cities = WarehouseCitie::with(['city' => function($query){
            $query = $query->with('country');
        }])->where('warehouse_id',$id)->paginate(10);

        $checkcities = WarehouseCitie::select('city_id')->get()->toarray();

        $city = Citie::with('country')->whereNotIn('id',$checkcities)->where('is_active',1)->paginate(10);

        return view('backend.warehouses.cities', compact('cities','city','id'));
    }

    public function assigned(Request $request)
    {
        $ids = $request->cities;
        foreach($ids as $v_id){
            $data = array();
            $data['warehouse_id'] = $request->id;
            $data['city_id'] = $v_id;

            WarehouseCitie::insert($data);
        }
        return response()->json(['success'=>true]);
    }
}
