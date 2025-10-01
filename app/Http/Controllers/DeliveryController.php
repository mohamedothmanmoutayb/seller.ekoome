<?php

namespace App\Http\Controllers;
use App\Models\Lead;
use App\Models\User;
use App\Models\historystatu;
use Illuminate\Http\Request;
use Auth;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = 0;
        $agents = User::with(['History' => function($query){
            $query = $query->with('leadlivreur');
        }])->where('id_role',7)->where('users.country_id', Auth::user()->country_id);
        if($request->agent){
            $agents = $agents->where('id',$request->agent);
        }
        $agents = $agents->get();
        $users = User::where('id_role',7)->where('users.country_id', Auth::user()->country_id)->get();
        
        return view('backend.delivery.index', compact('agents','users'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
