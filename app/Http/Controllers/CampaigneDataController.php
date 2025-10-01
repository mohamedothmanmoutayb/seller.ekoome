<?php

namespace App\Http\Controllers;

use App\Models\{CampaigneData, Product,Countrie,SettingPercentage,Scenario};
use Illuminate\Http\Request;

class CampaigneDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaignesData = CampaigneData::with('product:id,name')
                            ->where('id_client', auth()->user()->id)
                            ->where('id_country', auth()->user()->country_id)
                            ->latest()->paginate(15);

        return view('backend.campaigne.index', compact('campaignesData'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('id_user', auth()->user()->id)->where('id_country', auth()->user()->country_id)->get();


        $bool = true;

        $countries = Countrie::get();
    
        return view('backend.campaigne.create', compact('products', 'countries', 'bool'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {      
        


        $request->merge([
            'id_client' => auth()->user()->id,
            'id_country' => auth()->user()->country_id,
        ]);

       

        $scenarios = array();

        $scenario = null;
       
       
        
        $campaigne = CampaigneData::create($request->all());
        
        $totalLeadsConfirmed = number_format(($campaigne->totalLeads * $campaigne->confirmation_rate)/100,0) ;
      
        $totalLeadsDelivred = number_format(($totalLeadsConfirmed * $campaigne->delivery_rate)/100,0);

        $totalLeads = intval(($request->quantity/$totalLeadsDelivred)*$request->totalLeads);
//dd( $totalLeads);
        $result = ($request->quantity * $request->price_sale) - ($request->fees  + $request->cost_ad * $totalLeads) + ($request->cost_product * $request->quantity);
        
        $campaigne->update(
            [
                'totalLeadsNeeded' => $totalLeads,
                'result' => $result
            ]
        );
        


        if($result > 0){
           
                
                $settingPercentages = SettingPercentage::where('id_country', $campaigne->id_country)->where('scenario', '+')->limit(3)->get();
               
                foreach ($settingPercentages as $setting) {
                    $scenario = new Scenario();
                    if($setting->percentage_upsell > 0){                       
                        $scenario->price_sale = $request->price_sale + (($request->price_sale * $setting->percentage_upsell)/100);
                    }else
                        $scenario->price_sale = $request->price_sale;
                    if($setting->percentage_callcenter > 0){
                        $scenario->confirmation_rate = $request->confirmation_rate + $setting->percentage_callcenter;
                    }else
                        $scenario->confirmation_rate = $request->confirmation_rate;
                    if($setting->percentage_delivred > 0){
                        $scenario->delivery_rate = $request->delivery_rate + $setting->percentage_delivred;
                    }else{
                        $scenario->delivery_rate = $request->delivery_rate;
                    }   
                        $scenario->type = $setting->scenario_type;
                        $scenario->id_campaigne = $campaigne->id;
                        $scenario->id_client = auth()->user()->id;

                        $totalLeadsConfirmed = number_format(($campaigne->totalLeads * $scenario->confirmation_rate)/100,0);
      
                        $totalLeadsDelivred = number_format(($totalLeadsConfirmed * $scenario->delivery_rate)/100,0);

                        $scenario->totalLeads = number_format(($request->quantity/$totalLeadsDelivred)*$campaigne->totalLeads,0);

                        $scenario->profit = ($request->quantity * $scenario->price_sale) - ($request->fees  + $request->cost_ad *  $scenario->totalLeads) + ($request->cost_product * $request->quantity);

                        $scenario->save();

                        array_push($scenarios, $scenario);
                        
                }

            
        }elseif($result < 0){
           
            
                $settingPercentages = SettingPercentage::where('id_country', $campaigne->id_country)->where('scenario', '-')->limit(3)->get();
                foreach ($settingPercentages as $setting) {
                    $scenario = new Scenario();
                    if($setting->percentage_upsell > 0){                       
                        $scenario->price_sale = $request->price_sale + (($request->price_sale * $setting->percentage_upsell)/100);
                    }else
                        $scenario->price_sale = $request->price_sale;
                    if($setting->percentage_callcenter > 0){
                        $scenario->confirmation_rate = $request->confirmation_rate + $setting->percentage_callcenter;
                    }else
                        $scenario->confirmation_rate = $request->confirmation_rate;
                    if($setting->percentage_delivred > 0){
                        $scenario->delivery_rate = $request->delivery_rate + $setting->percentage_delivred;
                    }else{
                        $scenario->delivery_rate = $request->delivery_rate;
                    }
                    
                    $scenario->type = $setting->scenario_type;
                    
                    $scenario->id_campaigne = $campaigne->id;

                    $scenario->id_client = auth()->user()->id;

                    $totalLeadsConfirmed = number_format(($campaigne->totalLeads * $scenario->confirmation_rate)/100,0);
      
                    $totalLeadsDelivred = number_format(($totalLeadsConfirmed * $scenario->delivery_rate)/100,0);

                    $scenario->totalLeads = number_format(($request->quantity/$totalLeadsDelivred)*$campaigne->totalLeads,0);

                    $scenario->profit = ($request->quantity * $scenario->price_sale) - ($request->fees  + $request->cost_ad *  $scenario->totalLeads) + ($request->cost_product * $request->quantity);

                    $scenario->save();

                    array_push($scenarios, $scenario);
                    
                }
                


        }else{
           
                $scenario = new Scenario();
                $settingPercentages = SettingPercentage::where('id_country', $campaigne->id_country)->where('scenario', '0')->limit(3)->get();
                foreach ($settingPercentages as $setting) {
                    $scenario = new Scenario();
                    if($setting->percentage_upsell > 0){                       
                        $scenario->price_sale = $request->price_sale + (($request->price_sale * $setting->percentage_upsell)/100);
                    }else
                        $scenario->price_sale = $request->price_sale;
                    if($setting->percentage_callcenter > 0){
                        $scenario->confirmation_rate = $request->confirmation_rate + $setting->percentage_callcenter;
                    }else
                        $scenario->confirmation_rate = $request->confirmation_rate;
                    if($setting->percentage_delivred > 0){
                        $scenario->delivery_rate = $request->delivery_rate + $setting->percentage_delivred;
                    }else{
                        $scenario->delivery_rate = $request->delivery_rate;
                    }
                    $scenario->type = $setting->scenario_type;
                    $scenario->id_campaigne = $campaigne->id;
                    $scenario->id_client = auth()->user()->id;

                    $totalLeadsConfirmed = number_format(($campaigne->totalLeads * $scenario->confirmation_rate)/100,0);
      
                    $totalLeadsDelivred = number_format(($totalLeadsConfirmed * $scenario->delivery_rate)/100,0);

                    $scenario->totalLeads = number_format(($request->quantity/$totalLeadsDelivred)*$campaigne->totalLeads,0);

                    $scenario->profit = ($request->quantity * $scenario->price_sale) - ($request->fees  + $request->cost_ad *  $scenario->totalLeads) + ($request->cost_product * $request->quantity);

                    $scenario->save();

                    array_push($scenarios, $scenario);
                }

        }
        

        return response()->json(['success' => true,'scenarios' => $scenarios, 'totalLeads' => $totalLeads, 'result' => $result]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampaigneData  $campaigneData
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $campaigne = CampaigneData::with('product','country','scenarios')->findOrfail($id);

        if($campaigne->id_client != auth()->user()->id)
            return back()->with('error', 'You are not authorized to view this campaigne');
       
        $scenarioUpsell = $campaigne->scenarios()->where('type', 'upsell')->first();
        $scenarioCallCenter = $campaigne->scenarios()->where('type', 'callcenter')->first();
        $scenarioShipping = $campaigne->scenarios()->where('type', 'delivered')->first();

        return view('backend.campaigne.view', compact('campaigne', 'scenarioUpsell', 'scenarioCallCenter', 'scenarioShipping'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampaigneData  $campaigneData
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaigneData $campaigneData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampaigneData  $campaigneData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampaigneData $campaigneData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaigneData  $campaigneData
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaigneData $campaigneData)
    {
        //
    }
}
