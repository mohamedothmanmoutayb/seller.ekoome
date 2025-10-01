<?php

namespace App\Http\Controllers;

use App\Models\LastmilleIntegration;
use App\Models\ShippingCompany;
use App\Models\Citie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;

class LastmilleIntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'id_country' => Auth::user()->country_id,
            'id_user' => Auth::user()->id,
            'auth_key' => $request->key,
            'id_lastmile' => $request->id_lastmile,
            'auth_id' => $request->auth_id,
            'name' => $request->name,
            'type' => $request->type,
            'open' => $request->open,
            'fragile' => $request->fragile,
            'fees_delivered' => $request->fees_delivered,
            'fees_returned' => $request->fees_returned,
        ];

        lastmilleintegration::insert($data);

        $shipping = ShippingCompany::where('id',$request->id_lastmile)->first();

        if($shipping->name == "AMEEX"){
            $client = new Client();
            // Define the URL of the API
            $url = 'https://api.ameex.app/customer/Cnfg/App';
            // Send the GET request asynchronously
            $response = $client->get($url);
            // Return the response body
            $data = json_decode($response->getBody() , true);
            foreach($data['data']['cnfg']['ameex_cities'] as $v_data){
                $check = Citie::where('name',$v_data['NAME'])->where('last_mille','AMEEX')->first();
                if(empty($check->id)){
                    $city = array();
                    $city['id_city_lastmille'] = $v_data['ID'];
                    $city['name'] = $v_data['NAME'];
                    $city['id_country'] = Auth::user()->country_id;
                    $city['last_mille'] = "AMEEX";
                    $city['fees_delivered'] = $request->fees_delivered;
                    $city['fees_returned'] = $request->fees_returned;
    
                    Citie::insert($city);
                }
            }
        }

        if($shipping->name == "OZONEXPRESS"){
            $client = new Client();
            // Define the URL of the API
            $url = 'https://api.ozonexpress.ma/cities';
            // Send the GET request asynchronously
            $response = $client->get($url);
            // Return the response body
            $data = json_decode($response->getBody() , true);
            foreach($data['CITIES'] as $v_data){
                $check = Citie::where('name',$v_data['NAME'])->where('last_mille','OZONEXPRESS')->first();
                if(empty($check->id)){
                    $city = array();
                    $city['id_city_lastmille'] = $v_data['ID'];
                    $city['name'] = $v_data['NAME'];
                    $city['id_country'] = Auth::user()->country_id;
                    $city['last_mille'] = "OZONEXPRESS";
                    $city['fees_delivered'] = $request->fees_delivered;
                    $city['fees_returned'] = $request->fees_returned;
    
                    Citie::insert($city);
                }
            }
        }

        if($shipping->name == "OLIVRAISON"){
            $client = new Client();
            // Define the URL of the API
            $url = 'https://partners.olivraison.com/auth/login';
            $headers = [
                'Content-Type' => 'application/json',
            ];
            $body = [
                "apiKey" => $request->auth_id,
                "secretKey" => $request->key,
            ];
            $response = Http::withHeaders($headers)->post($url, $body);

            if ($response->successful()) {
                $data = $response->json(); // Return JSON response
                if(!empty($data['token'])){
                    $token = $data['token'];
                }
            }
            if(!empty($token)){
              $client = new Client();
                $url = 'https://partners.olivraison.com/cities';
                // Send the GET request asynchronously
                $headers = [
                    'Authorization' => 'Bearer '.$token,
                ];
                $response = Http::withHeaders($headers)->get($url);
                    // Return the response body
                $data = json_decode($response->getBody() , true);
                foreach($data as $v_data){
                    $check = Citie::where('name',$v_data['name'])->where('last_mille','OLIVRAISON')->first();
                    if(empty($check->id)){
                        $city = array();
                        // $city['id_city_lastmille'] = $v_data['id'];
                        $city['name'] = $v_data['name'];
                        $city['id_country'] = Auth::user()->country_id;
                        $city['last_mille'] = "OLIVRAISON";
                        $city['fees_delivered'] = $request->fees_delivered;
                        $city['fees_returned'] = $request->fees_returned;

                        Citie::insert($city);
                    }
                }  
            }
            
        }

        if($shipping->name == "SPEEDEX"){
            $client = new Client();
            // Define the URL of the API
            $url = 'https://clients.speedex.ma/api/list-ville';
            // Send the GET request asynchronously
            $headers = [
                'Authorization' => 'Bearer '.$request->key,
            ];
            $response = Http::withHeaders($headers)->post($url);
            // Return the response body
            $data = $response->json();
            foreach($data['data'] as $v_data){
                $check = Citie::where('name',$v_data['city_name'])->where('last_mille','SPEEDEX')->first();
                if(empty($check->id)){
                    $city = array();
                    $city['name'] = $v_data['city_name'];
                    $city['id_country'] = Auth::user()->country_id;
                    $city['last_mille'] = "SPEEDEX";
                    $city['fees_delivered'] = $request->fees_delivered;
                    $city['fees_returned'] = $request->fees_returned;
    
                    Citie::insert($city);
                }
            }
        }

        if($shipping->name == "DIGYLOG"){
            $client = new Client();
            $url = 'https://api.digylog.com/api/v1/seller/cities';
            // Send the GET request asynchronously
            $headers = [
                'Authorization' => 'Bearer '.$request->key,
                'Referer' => 'https://apiseller.digylog.com',
                'Content-Type' => 'application/json'
            ];
            $response = Http::withHeaders($headers)->get($url);
            // Return the response body
            $data = json_decode($response->getBody() , true);
            foreach($data as $v_data){
                $check = Citie::where('name',$v_data['name'])->where('last_mille','DIGYLOG')->first();
                if(empty($check->id)){
                    $city = array();
                    $city['id_city_lastmille'] = $v_data['id'];
                    $city['name'] = $v_data['name'];
                    $city['id_country'] = Auth::user()->country_id;
                    $city['last_mille'] = "DIGYLOG";
                    $city['fees_delivered'] = $request->fees_delivered;
                    $city['fees_returned'] = $request->fees_returned;

                    Citie::insert($city);
                }
            }
        }

        if($shipping->name == "ONESSTA"){
            $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $request->api_key,
            'Accept' => 'application/json',
            'API-Key' => $request->key,
            'Client-ID' => $request->auth_id,
            ];

            $response = Http::withHeaders($headers)->get('https://api.onessta.com/api/v1/c/cities');
                if ($response->successful()) {
                $data = $response->json();

                if ($data['success'] && !empty($data['data']['cities'])) {

                foreach ($data['data']['cities'] as $city) {
                    $existingCity = Citie::where('name', $city['name'])
                                        ->where('id_country', 11)
                                        ->where('last_mille', 'ONESSTA')
                                        ->first();

                    if (!$existingCity) {
                        Citie::create([
                            'name' => $city['name'],
                            'id_country' => 11,
                            'city_id' => $city['id'],
                            'last_mille' => 'ONESSTA',
                            'is_active' => 1,
                            'fees_delivered' => $request->fees_delivered,
                            'fees_returned' => $request->fees_returned
                        ]);
                    } else {
                        if (empty($existingCity->city_id)) {
                            $existingCity->update([
                                'city_id' => $city['id'],
                                'last_mile' => 'ONESSTA'
                            ]);
                        }
                    }
                }

                return redirect()->back()->with('success', 'Cities fetched and updated successfully from Onessta.');
                }
            }

            return redirect()->back()->with('error', 'Failed to fetch cities from Onessta.');
        }

        if($shipping->name == "MABERR"){
            $client = new Client();
            // Define the URL of the API
            $url = 'https://api.ozonexpress.ma/cities';
            // Send the GET request asynchronously
            $response = $client->get($url);
            // Return the response body
            $data = json_decode($response->getBody() , true);
            foreach($data['CITIES'] as $v_data){
                $check = Citie::where('name',$v_data['NAME'])->where('last_mille','MABERR')->first();
                if(empty($check->id)){
                    $city = array();
                    $city['id_city_lastmille'] = $v_data['ID'];
                    $city['name'] = $v_data['NAME'];
                    $city['id_country'] = Auth::user()->country_id;
                    $city['last_mille'] = "MABERR";
                    $city['fees_delivered'] = $request->fees_delivered;
                    $city['fees_returned'] = $request->fees_returned;
    
                    Citie::insert($city);
                }
            }
        }

        if($shipping->name == "TigerLine"){
            $client = new Client();
            // Define the URL of the API
            $url = 'https://tigerline.ma/admin/cities.json';
            // Send the GET request asynchronously
            $response = $client->get($url);
            // Return the response body
            $data = json_decode($response->getBody() , true);
            foreach($data as $v_data){
                $check = Citie::where('name',$v_data['city'])->where('last_mille','TigerLine')->first();
                if(empty($check->id)){
                    $city = array();
                    $city['id_city_lastmille'] = $v_data['sku'];
                    $city['name'] = $v_data['city'];
                    $city['id_country'] = Auth::user()->country_id;
                    $city['last_mille'] = "TigerLine";
                    $city['fees_delivered'] = $request->fees_delivered;
                    $city['fees_returned'] = $request->fees_returned;
    
                    Citie::insert($city);
                }
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LastmilleIntegration  $lastmilleIntegration
     * @return \Illuminate\Http\Response
     */
    public function show(LastmilleIntegration $lastmilleIntegration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LastmilleIntegration  $lastmilleIntegration
     * @return \Illuminate\Http\Response
     */
    public function edit(LastmilleIntegration $lastmilleIntegration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LastmilleIntegration  $lastmilleIntegration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = [
            'name' => $request->name,
            'auth_key' => $request->key,
            'auth_id' => $request->auth_id,
            'api_key' => $request->api_key,
            'type' => $request->type,
            'fragile' => $request->fragile,
            'open' => $request->open,
            'fees_delivered' => $request->fees_delivered,
            'fees_returned' => $request->fees_return,
        ];

        lastmilleintegration::where('id',$request->id_integration)->update($data);

        return back();
    }

    public function destroy(Request $request)
    {
        lastmilleintegration::where('id',$request->id)->where('id_user',Auth::user()->id)->delete();

        return back();
    }

    public function details($id)
    {
        $lastmilles = lastmilleintegration::where('id_lastmile',$id)->where('id_country',Auth::user()->country_id)->where('id_user',Auth::user()->id)->get();
        $shippingCompany = ShippingCompany::find($id);
        $isOnessta = ($shippingCompany && strtoupper($shippingCompany->name) === 'ONESSTA');

        return view('backend.companies.detail', compact('lastmilles','id', 'isOnessta','shippingCompany'));
    }

    public function datalast(Request $request)
    {
        $lastmille = lastmilleintegration::where('id',$request->id)->where('id_user', Auth::user()->id)->first();

        return response()->json($lastmille);
    }
}
