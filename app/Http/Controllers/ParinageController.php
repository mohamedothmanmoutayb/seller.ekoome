<?php

namespace App\Http\Controllers;

use App\Models\{Parinage,User};
use Illuminate\Http\Request;

class ParinageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parinage = Parinage::all();
       
        if($request->search){
            $parinage = Parinage::where('ref', 'like', '%' . $request->search . '%')->get();
        }else{
            $parinage = Parinage::all();
        }
        return view('backend.parinage.index',compact('parinage'));
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
        $length = 10; // Length of the random string
        $characters = '0123456789ABCDEF0123456789ABCDEGDKLMNOPQRSTUVWXYZ0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Characters to use
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $url = 'https://seller.ecomfulfilment.eu/register?ref='.$randomString;
        $parinage = new Parinage();
        $parinage->url = $url;
        $parinage->ref = $randomString;
        $parinage->note = $request->note;
        $parinage->save();
        return response()->json(['success',true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parinage  $parinage
     * @return \Illuminate\Http\Response
     */
    public function show(Parinage $parinage)
    {
        //
    }

    public function newUsers(){
        $newusers = User::where('id_role','2')->where('ref','!=',null)->where('is_active',0)->paginate(20);
        
        return view('backend.parinage.newusers',compact('newusers'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parinage  $parinage
     * @return \Illuminate\Http\Response
     */
    public function edit(Parinage $parinage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parinage  $parinage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parinage  $parinage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Parinage::where('id',$request->id)->delete();
        return response()->json(['success',true]);
    }
}
