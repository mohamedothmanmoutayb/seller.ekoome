<?php

namespace App\Http\Controllers;

use App\Models\ShippingCountrie;
use Illuminate\Http\Request;

class ShippingCountrieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = ShippingCountrie::paginate(10);
        

        return view('backend.shipping.index', compact('countries'));
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
        $data = [
            'name' => $request->country,
            'dayli' => $request->dayli,
            'type_shippng' => $request->type,
            'warehouse' => $request->warehouse,
            'contact' => $request->contact,
        ];

        ShippingCountrie::insert($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShippingCountrie  $shippingCountrie
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingCountrie $shippingCountrie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingCountrie  $shippingCountrie
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingCountrie $shippingCountrie)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingCountrie  $shippingCountrie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingCountrie $shippingCountrie)
    {
        if($request->type){
             $data = [
                'name' => $request->country,
                'dayli' => $request->dayli,
                'type_shippng' => $request->type,
                'warehouse' => $request->warehouse,
                'contact' => $request->contact,
            ];

            ShippingCountrie::where('id',$request->id)->update($data);
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['remplier'=>false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingCountrie  $shippingCountrie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        ShippingCountrie::where('id',$request->id)->delete();
        return response()->json(['success'=>true]);
    }
    public function details(ShippingCountrie $shippingCountrie,$id)
    {
        $data = ShippingCountrie::where('id',$id)->first();
        
        $data = json_decode($data);
        return response()->json($data);
    }
}
