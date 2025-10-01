<?php

namespace App\Http\Controllers;

use App\Models\LastmilleIntegration;
use App\Models\ShippingCompany;
use App\Models\Countrie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LastmilleCompanyController extends Controller
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
        // $companies = ShippingCompany::get();
        // $lastMile = array();
        // foreach($companies as $company){
        //     //take companies that works in italy 
        //     if($company->countries) {             
        //         if(in_array(auth()->user()->country_id, $company->countries)){
        //             $lastMile[] = $company;
        //         }
        //     }
           
        // }
       
        if($request->name){
            $companies = ShippingCompany::with('lastmilleinteg')->where('name','like','%'.$request->name.'%')->get();
            
        }else{
            $companies = ShippingCompany::with('lastmilleinteg')->get();
        }   
     
       $countries = Countrie::get();
       
       return view('backend.companies.list', compact('companies','countries'));
    }

    
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $name = strtoupper($request->name);
        $company = ShippingCompany::where('name',$name)->count();

        if($company > 0){
            return response()->json(['error'=>false]);
        }

        $data = [
                'countries' => $request->countries,
                'name' => $name,
        ];
        
        ShippingCompany::create($data);
        
        return response()->json(['success'=>true]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function show(Sheet $sheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = ShippingCompany::where('id',$request->id)->first();

        return response()->json(['company'=>$company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $name = strtoupper($request->name);

        $data = [
                'countries' => $request->countries,
                'name' => $name,
        ];

        ShippingCompany::where('id',$request->id)->update($data);
        
        return response()->json(['success'=>true]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        ShippingCompany::where('id',$request->id)->delete();
        return response()->json(['success'=>true]);
    }
}
