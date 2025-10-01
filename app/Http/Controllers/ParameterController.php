<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Auth;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameter = Parameter::where('id_country', Auth::user()->country_id)->first();

        return view('backend.parameters.index', compact('parameter'));
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
        $data['id_country'] = Auth::user()->country_id;
        $data['app_name'] = $request->name;
        $data['vat_number'] = $request->vat;
        $data['email'] = $request->email;
        $data['country'] = $request->country;
        $data['city'] = $request->city;
        $data['address'] = $request->address;

        Parameter::insert($data);
        
        return response()->json(['success'=>true]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter)
    {
        $data = array();
        $data['app_name'] = $request->name;
        $data['vat_number'] = $request->vat;
        $data['email'] = $request->email;
        $data['zipcod'] = $request->zipcod;
        $data['country'] = $request->country;
        $data['city'] = $request->city;
        $data['address'] = $request->address;

        Parameter::where('id',$request->id)->update($data);
        
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        //
    }
}
