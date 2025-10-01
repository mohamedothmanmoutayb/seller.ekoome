<?php

namespace App\Http\Controllers;

use App\Models\LabelParameter;
use Illuminate\Http\Request;
use Auth;

class LabelParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameter = LabelParameter::where('id_country', Auth::user()->country_id)->first();

        return view('backend.label-parameters.index', compact('parameter'));
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
        $data['zipcod'] = $request->zipcod;
        $data['telephone'] = $request->telephone;
        $data['city'] = $request->city;
        $data['address'] = $request->address;

        LabelParameter::insert($data);
        
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LabelParameter  $labelParameter
     * @return \Illuminate\Http\Response
     */
    public function show(LabelParameter $labelParameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LabelParameter  $labelParameter
     * @return \Illuminate\Http\Response
     */
    public function edit(LabelParameter $labelParameter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LabelParameter  $labelParameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LabelParameter $labelParameter)
    {
        $data = array();
        $data['zipcod'] = $request->zipcod;
        $data['telephone'] = $request->telephone;
        $data['city'] = $request->city;
        $data['address'] = $request->address;
        
        LabelParameter::where('id',$request->id)->update($data);
        
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LabelParameter  $labelParameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabelParameter $labelParameter)
    {
        //
    }
}
