<?php

namespace App\Http\Controllers;

use App\Models\Countrie;
use Illuminate\Http\Request;

class CountrieController extends Controller
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
    public function index(Request $request)
    {
        $countries = Countrie::orderby('id','desc');
        
        if($request->search){
            $countries = $countries->where('name',$request->search)->orwhere('frais_confirmation',$request->search)->orwhere('frais_delivery',$request->search);
        }
        $countries = $countries->paginate(10);

        return view('backend.Countries.index', compact('countries'));
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
            'flag' => $request->falg,
            'currency' => $request->currency,
            'negative' => $request->negative,
        ];

        Countrie::insert($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Countrie  $countrie
     * @return \Illuminate\Http\Response
     */
    public function show(Countrie $countrie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Countrie  $countrie
     * @return \Illuminate\Http\Response
     */
    public function edit(Countrie $countrie)
    {
        //
    }
    
    public function details(Countrie $countrie,$id)
    {
        $data = Countrie::where('id',$id)->first();
        
        $data = json_decode($data);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Countrie  $countrie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Countrie $countrie)
    {
        
        $data = [
            'name' => $request->name,
            'negative' => $request->negative,
            'currency' => $request->currency,
            'flag' => $request->flag,
        ];

        Countrie::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Countrie  $countrie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Countrie::where('id',$request->id)->delete();
        return response()->json(['success'=>true]);
    }
}
