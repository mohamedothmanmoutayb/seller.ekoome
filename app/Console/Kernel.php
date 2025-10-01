<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Sheet;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Zipcode;
use App\Models\Countrie;
use Google\Service\Sheets;
use App\Models\LeadProduct;
use App\Models\HistoryStatu;
use Illuminate\Http\Request;
use App\Models\ShopifyIntegration;
use Illuminate\Support\Facades\Http;
use App\Http\Services\GoogleSheetServices;
use Auth;
use DateTime;
use DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $command = [
        \App\Console\Commands\LeadCron::class,
        \App\Console\Commands\InitializeUsageTracking::class,
        \App\Console\Commands\PopulateUsageData::class,
        ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('analytics:send-daily')
                ->dailyAt('00:00');

        $schedule->command('usage:populate --all')->hourly();

        $schedule->command('analytics:send-weekly')
                ->weeklyOn(1, '00:00');

        $schedule->command('analytics:send-monthly')
                ->monthlyOn(1, '00:00');

        // $schedule->command('backup:run', ['--only-db'])->hourly();
        $schedule->call(function(){
            $countries = Countrie::get();
            $data = (new GoogleSheetServices ())->getClient();
            $client = $data;
            //dd($client);
            $date = new DateTime();
            $sheets = Sheet::where('status',1)->where('deleted_at',0)->inRandomOrder()->get();
            // try{
                foreach($sheets as $v_sheet){
                    $userss = User::where('id',$v_sheet->id_user)->first();
                    $ne = substr(strtoupper($userss->name), 0 , 1);
                    $n = substr(strtoupper($userss->name), -1);
                    $service = new Sheets($client);
                    $spreadsheetId = $v_sheet->sheetid;
                    $spreadsheetName = $v_sheet->sheetname.'!A2:O';
                    $range = $spreadsheetName;              
                    $doc = $service->spreadsheets_values->get($spreadsheetId, $range);
                    $response = $doc;

                    if(empty($response['values'])) {
                        Log::info("Sheet {$v_sheet->sheetname} is empty. Skipping.");
                        break;
                    }

                    for($i = 0 ; $i < 50 ; $i++){
                        $lastsheet = Lead::where('id_sheet',$v_sheet->id)->orderby('id','desc')->first();

                        if(empty($lastsheet)) {
                            Log::info("No previous leads found for sheet {$v_sheet->sheetname}. Skipping.");
                            break;
                        }
                        
                        $sheeets = Sheet::where('id',$v_sheet->id)->first();
                        $index = $sheeets->index + 1;
                        
                        // $last = Lead::orderby('id','DESC')->first();
                        // if(empty($last->id)){
                        //     $kk = 1;
                        // }else{
                        //     $kk = $last->id + 1;
                        // }//dd($v_sheet->id);
                        // if (isset($response['values'][$index]) && isset($response['values'][$index][1])) {
                        //     $countsku = count(explode(',', $response['values'][$index][1]));
                        // } else {
                        //     Log::error("Missing expected data at index $index in response['values']");
                        //     $countsku = 0; 
                        // }
                        // if (isset($response['values'][$index]) && isset($response['values'][$index][1])) {
                        //     $detailsku = explode(',', $response['values'][$index][1]);
                        // } else {
                        //     Log::warning("Missing expected data for detailsku at index $index.");
                        //     $detailsku = []; 
                        // }

                        $last = Lead::orderby('id','DESC')->first();
                        if(empty($last->id)){
                            $kk = 1;
                        }else{
                            $kk = $last->id + 1;
                        }
                        
                        if (!isset($response['values'][$index][9])) {
                             Log::warning("Phone number is empty at index $index in sheet {$v_sheet->sheetname}");
                            continue;
                        }
                        
                        if (isset($response['values'][$index]) && isset($response['values'][$index][1])) {
                            $countsku = count(explode(',', $response['values'][$index][1]));
                        } else {
                            Log::error("Missing expected data at index $index in response['values']");
                            $countsku = 0; 
                        }
                        
                        if (isset($response['values'][$index]) && isset($response['values'][$index][1])) {
                            $detailsku = explode(',', $response['values'][$index][1]);
                        } else {
                            Log::warning("Missing expected data for sku detail at index $index.");
                            $detailsku = []; 
                        }

                        if($countsku < 2){
                            $detilcount = count(explode(':' , $detailsku[0]));
                            $detail3 = explode(':' ,$detailsku[0]);
                            if($detilcount < 2){
                                $detsk = $detail3[0];
                                $quantity = $response['values'][$index][2];
                            }else{
                                $detsk = $detail3[0];
                                $quantity = $detail3[1];
                            }
                        }else{
                            $detailcount = count(explode(':' , $detailsku[$countsku - 2]));
                            $detail = $detailsku[$countsku - 2];
                            $detail2 = explode(':' ,$detail);
                            $detailscount = count(explode(':' , $detail));
                            $detsk = $detail2[$detailcount - 2];
                            $quantity = $detail2[$detailcount - 1];
                        }
                        
                        //dd($detsk , $detailcount , $detail2);
                        $checkproduct = Product::where('sku',$detsk)->where('id_user',$v_sheet->id_user)->first();
                        //($checkproduct);
                        if(!empty($checkproduct->id)){
                            $countduplicated = Lead::where('id_product',$checkproduct->id)->where('phone','like','%'.$response['values'][$index][9].'%')->whereDate('created_at',$date->format('Y-m-d'))->count();
                            $clients = Client::where('phone1',$response['values'][$index][4])->first();
                            $countries = Countrie::where('id',$v_sheet->id_warehouse)->first();
                            if(empty($clients->phone1)){
                                $client = new Client();
                                $client->id_user = $v_sheet->id_user;
                                $client->id_country = $v_sheet->id_warehouse;
                                if(!empty($response['values'][$index][6])){
                                    $client->city = $response['values'][$index][6];
                                }
                                if(!empty($response['values'][$index][4])){
                                    $client->name = $response['values'][$index][4];
                                }
                                if(!empty($response['values'][$index][9])){
                                    $client->phone1 = $response['values'][$index][9];
                                }
                                if(!empty($response['values'][$index][5])){
                                    $client->address = $response['values'][$index][5];
                                }
                                if(!empty($response['values'][$index][9]) && !empty($response['values'][$index][6]) && !empty($response['values'][$index][4]) ){
                                    $client->save();
                                    $clients = Client::where('phone1',$response['values'][$index][4])->first();
                                }
                            }
                            $data = array();
                            $data['n_lead'] = $ne .''.$n.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT);
                            if(!empty($response['values'][$index][0])){
                                $data['id_order'] = $response['values'][$index][0];
                            }
                            $data['id_sheet'] = $v_sheet->id;
                            $data['index_sheet'] = $index;
                            $data['id_user'] = $v_sheet->id_user;
                            $data['id_country'] = $checkproduct->id_country;
                            $data['id_product'] = $checkproduct->id;
                            if(empty($clients->phone1)){
                                $data['client_id'] = $client->id;
                            }else{
                                $data['client_id'] = $clients->id;
                                $data['isdouble'] = true;
                            }
                            if(!empty($response['values'][$index][4])){
                                $data['name'] = $response['values'][$index][4];
                            }
                            if(!empty($response['values'][$index][8])){
                                $data['zipcod'] = $response['values'][$index][8];
                            }
                            if(!empty($response['values'][$index][11])){
                                $data['email'] = $response['values'][$index][11];
                            }
                            if(!empty($response['values'][$index][7])){
                                $data['province'] = $response['values'][$index][7];
                            }
                            if(!empty($response['values'][$index][9])){
                                $data['phone'] =  $response['values'][$index][9];
                            }
                            if(!empty($response['values'][$index][6])){
                                $data['city'] = $response['values'][$index][6];
                            }
                            if(!empty($response['values'][$index][5])){
                                $data['address'] = $response['values'][$index][5];
                            }
                            if(!empty($response['values'][$index][3])){
                                if(str_contains($response['values'][$index][3], ','))
                                {
                                    $total = str_replace(',', '.', $response['values'][$index][3]);
                                    $data['lead_value'] = $total;
                                }else{
                                    $data['lead_value'] = $response['values'][$index][3] ?? 0;
                                }
                            }
                            $data['quantity'] = $quantity ?? 1;
                            if(!empty($response['values'][$index][13])){
                                if(strtoupper($response['values'][$index][13]) != "COD" && str_starts_with(strtoupper($response['values'][$index][13]), 'P')){
                                    $data['ispaidapp'] = "1";                  
                                    $data['method_payment'] = "PREPAID";
                                }else{
                                    $data['method_payment'] = "COD";
                                }
                            }else{
                                $data['method_payment'] = "COD";
                            }
                            
                            if($countduplicated != 0){
                                $data['status_confirmation'] = "duplicated";    
                            }
                            if(Zipcode::where('id_country',$checkproduct->id_country)->where('name', $response['values'][$index][8])->count() != 0){
                                $data['status_confirmation'] = "out of area";
                            }
                            if(!empty($data['First name']) || !empty(str_replace(' ', '', $data['phone'])) || !empty($data['name']) || !empty(str_replace(' ', '', $response['values'][$index][4]))){//dd($data);
                                $data['market'] = "Google Sheet";
                                Lead::insert($data);
                                Sheet::where('id',$v_sheet->id)->update(['index' => $index]);
                                $last_lead_hist = Lead::where('n_lead',$ne .''.$n.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT))->first();
                                $lastlead = Lead::orderby('id','DESC')->first();
                                if(!isset($lastlead->id)){
                                    $lastll = 1;
                                }else{
                                    $lastll = $lastlead->id;
                                }
                                for($i = 0 ; $i < $countsku ; $i++){
                                    $detilcount = count(explode(':' , $detailsku[$i]));
                                    if($detilcount < 2){
                                        $detail2 = explode(':' ,$detailsku[$i]);
                                        $sku = $detail2[0];
                                        $quantity = $response['values'][$index][2];
                                    }else{
                                        $detail2 = explode(':' ,$detailsku[$i]);
                                        $sku = $detail2[0];
                                        $quantity = $detail2[1];
                                    }
                                    $checkproduct = Product::where('sku',$sku)->first();
                                    if(!empty($checkproduct->id)){
                                        $data2 = array();
                                        $data2['id_lead'] = $lastll;
                                        $data2['id_product'] = $checkproduct->id;
                                        $data2['quantity'] = $quantity;
                                        if(!empty($response['values'][$index][3])){
                                            if($i == 0){
                                                $data2['lead_value'] = $response['values'][$index][3] ?? 0;
                                            }else{
                                                $data2['lead_value'] = "0";
                                            }
                                        }
                                        LeadProduct::insert($data2);
                                    }
                                }
    
                                $sumquantity = LeadProduct::where('id_lead',$lastll)->sum('quantity');
                                Lead::where('id',$lastll)->update(['quantity' => $sumquantity]);
    
                                $hist = array();
                                $hist['id_lead'] = $lastlead->id;
                                $hist['status'] = $lastlead->status_confirmation;
                                $hist['comment'] = $lastlead->status_confirmation;
                                HistoryStatu::insert($hist);
                            }
                        }
                    }
                }
            // }catch(\Exception $e){
            //     redirect()->back();
            // }
        })->everyTwoMinutes();
        $schedule->call(function(){
            $date = new DateTime();
            $noanswers = Lead::where('status_confirmation','LIKE','%'.'no answer'.'%')->where('date_call','>', $date->format('Y-m-d H:i'))->where('id_assigned','!=', Null)->get();
            foreach($noanswers as $v_lead){
                Lead::where('id',$v_lead)->update(['id_assigned' => Null , 'status' => '0']);
            }
        })->everyFiveMinutes();   

        // $schedule->call(function(){
        //     $date = new DateTime();
        //     try{
        //         $shopify = ShopifyIntegration::inRandomOrder()->get();
        //         foreach($shopify as $v_shopify){
        //             try{
        //                 $dt = \Carbon\carbon::today()->format('Y-m-d');
        //                 $verion = '2023-07';
        //                 $url = 'https://'.$v_shopify->api_key.''.$v_shopify->admin_api_access_token.'@'.$v_shopify->subdomain.'.myshopify.com/admin/api/'.$verion.'/orders.json?status=open&created_at_min='.$dt.' 00:00&order=created_at asc&limit=250';
        //                 //dd($url);
        //                 $responses = Http::get($url);
        //                 $jsonData = $responses->json();
        //                 $lastindex = ShopifyIntegration::where('id',$v_shopify->id)->first();
        //                 $use = User::where('id',$lastindex->id_user)->first();
        //                 if($lastindex){
        //                     $index = $lastindex->last_index + 1;
        //                 }else{
        //                     $index = 1;
        //                 }
        //                 $countorders = count($jsonData['orders']);
        //                 for($i = 0 ; $i <= $countorders ; $i++ ){
        //                     //dd($jsonData['orders'][$i]['payment_gateway_names'][0]);
        //                     //dd($jsonData['orders'][$i]['current_total_price'] - $jsonData['orders'][$i]['total_discounts']);
        //                     $datshop = $jsonData['orders'][$lastindex->last_index]['created_at'];
        //                     if(date('Y-m-d H:i:s', strtotime($datshop)) >= $v_shopify->created_at){
        //                         //dd($jsonData['orders'][$i]['created_at']);
        //                         $checklead = Lead::where('id_order',$jsonData['orders'][$lastindex->last_index]['id'])->where('id_user',$lastindex->id_user)->where('id_country',$lastindex->id_country)->first();
        //                         if(empty($checklead)){
        //                             $userss = User::where('id',$v_shopify->id_user)->first();
        //                             $ne = substr(strtoupper($userss->name), 0 , 1);
        //                             $n = substr(strtoupper($userss->name), -1);
        //                             $lastorder = Lead::orderby('id','DESC')->first();
        //                             if(!isset($lastorder->id)){
        //                                 $kkk = 1;
        //                             }else{
        //                                 $kkk = $lastorder->id + 1;
        //                             }
        //                             $countsku = count(explode(',' , $jsonData['orders'][$lastindex->last_index]['line_items'][0]['sku']));
        //                             $detailsku = explode(',' , $jsonData['orders'][$lastindex->last_index]['line_items'][0]['sku']);
        //                             if($countsku < 2){
        //                                 $detilcount = count(explode(':' , $detailsku[0]));
        //                                 $detail3 = explode(':' ,$detailsku[0]);
        //                                 if($detilcount < 2){
        //                                     $detsk = $detail3[0];
        //                                     $quantity = $jsonData['orders'][$lastindex->last_index]['line_items'][0]['quantity'];
        //                                 }else{
        //                                     $detsk = $detail3[0];
        //                                     $quantity = $detail3[1];
        //                                 }
        //                             }else{
        //                                 $detailcount = count(explode(':' , $detailsku[$countsku - 2]));
        //                                 $detail = $detailsku[$countsku - 2];
        //                                 $detail2 = explode(':' ,$detail);
        //                                 $detailscount = count(explode(':' , $detail));
        //                                 $detsk = $detail2[$detailcount - 2];
        //                                 $quantity = $detail2[$detailcount - 1];
        //                             }
        //                             $checksku = Product::where('id_user',$lastindex->id_user)->where('sku',$detsk)->where('id_country',$lastindex->id_country)->first();
        //                             if($checksku){
        //                                 if(!empty($jsonData['orders'][$lastindex->last_index]['total_price']) && !empty($jsonData['orders'][$lastindex->last_index]['line_items'][0]['quantity'])){
        //                                     $checkduplicated = Lead::where('id_user',$lastindex->id_user)->where('phone',$jsonData['orders'][$lastindex->last_index]['customer']['default_address']['phone'])->where('id_product',$checksku->id)->count();
        //                                     $checklead = Lead::where('id_order',$jsonData['orders'][$lastindex->last_index]['id'])->where('id_user',$lastindex->id_user)->whereDate('created_at', $date->format('Y-m-d'))->first();//dd($jsonData['orders'][$i]);
        //                                     if(empty($checklead)){//dd( Lead::where('id_order',$jsonData['orders'][$i]['name'])->where('id_user',$lastindex->id_user)->first());
        //                                         $checklead2 = Lead::where('id_order',$jsonData['orders'][$lastindex->last_index]['name'])->where('id_user',$lastindex->id_user)->whereDate('created_at', $date->format('Y-m-d'))->first();
        //                                         if(empty($checklead2)){
        //                                             $datashopify = array();
        //                                             $nlead2 = $ne .''.$n.'-'.str_pad($kkk, 5 , '0', STR_PAD_LEFT);
        //                                             $datashopify['id_order'] = $jsonData['orders'][$lastindex->last_index]['name'];
        //                                             $datashopify['n_lead'] = $nlead2;
        //                                             $datashopify['id_user'] = $v_shopify->id_user;
        //                                             $datashopify['name'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['first_name'] .' '. $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['last_name'];
        //                                             $datashopify['phone'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['phone'];
        //                                             $datashopify['id_country'] = $checksku->id_country;
        //                                             $datashopify['city'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['city'];
        //                                             $datashopify['province'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['province'];
        //                                             $datashopify['zipcod'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['zip'];
        //                                             $datashopify['address'] = $jsonData['orders'][$lastindex->last_index]['shipping_address']['address1'] .' '. $jsonData['orders'][$lastindex->last_index]['shipping_address']['address2'];
        //                                             $datashopify['email'] = $jsonData['orders'][$lastindex->last_index]['customer']['email'];
        //                                             $datashopify['id_product'] = $checksku->id;//dd($datashopify);
        //                                             $datashopify['lead_value'] = $jsonData['orders'][$lastindex->last_index]['current_total_price'];
        //                                             $datashopify['quantity'] = $quantity;
        //                                             if($checkduplicated != 0){
        //                                                 $datashopify['status_confirmation'] = "duplicated";
        //                                             }
        //                                             if(Zipcode::where('name', $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['zip'])->count() != 0){
        //                                                 $datashopify['status_confirmation'] = "out of area";
        //                                             }
        //                                             $countrie = Countrie::where('id', $checksku->id_country)->first();
        //                                             if($countrie->name == "PORTUGAL"){
        //                                                 if(Zipcode::where('name', 'like','%'.substr($jsonData['orders'][$lastindex->last_index]['customer']['default_address']['zip'] , 0 , 4).'%')->count() != 0){
        //                                                     $data['status_confirmation'] = "out of area";
        //                                                 }
        //                                             }
        //                                             if($jsonData['orders'][$lastindex->last_index]['payment_gateway_names'][0] != "Cash on Delivery (COD)"){
        //                                                 // $datashopify['status_confirmation'] = "confirmed";
        //                                                 $datashopify['date_confirmed'] = new Datetime();
        //                                                 $datashopify['last_status_change'] = new DateTime();
        //                                                 $datashopify['date_shipped'] = new DateTime();
        //                                                 $datashopify['ispaidapp'] = "1";
        //                                             }
        //                                             $count = count($jsonData['orders'][$lastindex->last_index]['line_items']);
        //                                             $datashopify['market'] = 'Shopify';
        //                                             Lead::insert($datashopify);
        //                                             $incement = $lastindex->last_index + 1;
        //                                             ShopifyIntegration::where('id',$v_shopify->id)->update(['last_index' => $incement]);
        //                                             $idlead = Lead::where('n_lead',$nlead2)->first();
        //                                             for($j= 0 ; $j <= $count ; $j++ ){
        //                                                 $checksku2 = Product::where('id_user',$lastindex->id_user)->where('sku',$jsonData['orders'][$lastindex->last_index]['line_items'][$j]['sku'])->first();
        //                                                 if($checksku2){
        //                                                     $datashopify2 = array();
        //                                                     $datashopify2['id_lead'] = $idlead->id;
        //                                                     $datashopify2['id_product'] = $checksku2->id;
        //                                                     $datashopify2['quantity'] = $jsonData['orders'][$lastindex->last_index]['line_items'][$j]['quantity'];
        //                                                     if($j == 0){
        //                                                         $datashopify2['lead_value'] = (($jsonData['orders'][$lastindex->last_index]['line_items'][0]['price'] * $jsonData['orders'][$lastindex->last_index]['line_items'][0]['quantity']) - $jsonData['orders'][$lastindex->last_index]['total_discounts']);
        //                                                     }else{
        //                                                         $datashopify2['lead_value'] = $jsonData['orders'][$lastindex->last_index]['line_items'][$j]['price'] * $jsonData['orders'][$lastindex->last_index]['line_items'][$j]['quantity'];
        //                                                     }
        //                                                     if($jsonData['orders'][$lastindex->last_index]['payment_gateway_names'][0] != "Cash on Delivery (COD)"){
        //                                                         $datashopify2['date_delivred'] = new DateTime();
        //                                                     }
        //                                                     LeadProduct::insert($datashopify2);
        //                                                 }
        //                                             }
        //                                         }else{
        //                                             $incement = $lastindex->last_index + 1;
        //                                             ShopifyIntegration::where('id',$v_shopify->id)->update(['last_index' => $incement]);
        //                                         }
        //                                     }
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //             }catch(\Exception $e){
        //                 redirect()->back();
        //             }
        //         }
        //     }catch(\Exception $e){
        //         redirect()->back();
        //     }
        // })->everyFiveMinutes();

        // $schedule->call(function(){

        //     $date = new DateTime();
        //     try{
        //         $shopify = ShopifyIntegration::inRandomOrder()->get();
        //         foreach($shopify as $v_shopify){
        //             try{
        //                 $dt = \Carbon\carbon::today()->format('Y-m-d');
        //                 $verion = '2023-07';
        //                 $url = 'https://'.$v_shopify->api_key.''.$v_shopify->admin_api_access_token.'@'.$v_shopify->subdomain.'.myshopify.com/admin/api/'.$verion.'/orders.json?status=open&created_at_min='.$dt.' 00:00&order=created_at asc&limit=250';
        //                 //dd($url);
        //                 $responses = Http::get($url);
        //                 $jsonData = $responses->json();
        //                 $lastindex = ShopifyIntegration::where('id',$v_shopify->id)->first();
        //                 $use = User::where('id',$lastindex->id_user)->first();
        //                 if($lastindex){
        //                     $index = $lastindex->last_index + 1;
        //                 }else{
        //                     $index = 1;
        //                 }
        //                 $countorders = count($jsonData['orders']);
        //                 for($i = 0 ; $i <= $countorders ; $i++ ){
        //                     //dd($jsonData['orders'][$i]['payment_gateway_names'][0]);
        //                     //dd($jsonData['orders'][$i]['current_total_price'] - $jsonData['orders'][$i]['total_discounts']);
        //                     $datshop = $jsonData['orders'][$lastindex->last_index]['created_at'];
        //                     if(date('Y-m-d H:i:s', strtotime($datshop)) >= $v_shopify->created_at){
        //                         //dd($jsonData['orders'][$i]['created_at']);
        //                         $checklead = Lead::where('id_order',$jsonData['orders'][$lastindex->last_index]['id'])->where('id_user',$lastindex->id_user)->where('id_country',$lastindex->id_country)->first();
        //                         if(empty($checklead)){
        //                             $userss = User::where('id',$v_shopify->id_user)->first();
        //                             $ne = substr(strtoupper($userss->name), 0 , 1);
        //                             $n = substr(strtoupper($userss->name), -1);
        //                             $lastorder = Lead::orderby('id','DESC')->first();
        //                             if(!isset($lastorder->id)){
        //                                 $kkk = 1;
        //                             }else{
        //                                 $kkk = $lastorder->id + 1;
        //                             }
        //                             $checksku = Product::where('id_user',$lastindex->id_user)->where('sku',$jsonData['orders'][$lastindex->last_index]['line_items'][0]['sku'])->where('id_country',$lastindex->id_country)->first();
        //                             if($checksku){
        //                                 if(!empty($jsonData['orders'][$lastindex->last_index]['total_price']) && !empty($jsonData['orders'][$lastindex->last_index]['line_items'][0]['quantity'])){
        //                                     $checkduplicated = Lead::where('id_user',$lastindex->id_user)->where('phone',$jsonData['orders'][$lastindex->last_index]['customer']['default_address']['phone'])->where('id_product',$checksku->id)->count();
        //                                     $checklead = Lead::where('id_order',$jsonData['orders'][$lastindex->last_index]['id'])->where('id_user',$lastindex->id_user)->whereDate('created_at', $date->format('Y-m-d'))->first();//dd($jsonData['orders'][$i]);
        //                                     if(empty($checklead)){//dd( Lead::where('id_order',$jsonData['orders'][$i]['name'])->where('id_user',$lastindex->id_user)->first());
        //                                         $checklead2 = Lead::where('id_order',$jsonData['orders'][$lastindex->last_index]['name'])->where('id_user',$lastindex->id_user)->whereDate('created_at', $date->format('Y-m-d'))->first();
        //                                         if(empty($checklead2)){
        //                                             $datashopify = array();
        //                                             $nlead2 = $ne .''.$n.'-'.str_pad($kkk, 5 , '0', STR_PAD_LEFT);
        //                                             $datashopify['id_order'] = $jsonData['orders'][$lastindex->last_index]['name'];
        //                                             $datashopify['n_lead'] = $nlead2;
        //                                             $datashopify['id_user'] = $v_shopify->id_user;
        //                                             $datashopify['name'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['first_name'] .' '. $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['last_name'];
        //                                             $datashopify['phone'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['phone'];
        //                                             $datashopify['id_country'] = $checksku->id_country;
        //                                             $datashopify['city'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['city'];
        //                                             $datashopify['province'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['province'];
        //                                             $datashopify['zipcod'] = $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['zip'];
        //                                             $datashopify['address'] = $jsonData['orders'][$lastindex->last_index]['shipping_address']['address1'] .' '. $jsonData['orders'][$lastindex->last_index]['shipping_address']['address2'];
        //                                             $datashopify['email'] = $jsonData['orders'][$lastindex->last_index]['customer']['email'];
        //                                             $datashopify['id_product'] = $checksku->id;//dd($datashopify);
        //                                             $datashopify['lead_value'] = $jsonData['orders'][$lastindex->last_index]['current_total_price'];
        //                                             $datashopify['quantity'] = $jsonData['orders'][$lastindex->last_index]['line_items'][0]['quantity'];
        //                                             if($checkduplicated != 0){
        //                                                 $datashopify['status_confirmation'] = "duplicated";
        //                                             }
        //                                             if(Zipcode::where('name', $jsonData['orders'][$lastindex->last_index]['customer']['default_address']['zip'])->count() != 0){
        //                                                 $datashopify['status_confirmation'] = "out of area";
        //                                             }
        //                                             $countrie = Countrie::where('id', $checksku->id_country)->first();
        //                                             if($countrie->name == "PORTUGAL"){
        //                                                 if(Zipcode::where('name', 'like','%'.substr($jsonData['orders'][$lastindex->last_index]['customer']['default_address']['zip'] , 0 , 4).'%')->count() != 0){
        //                                                     $data['status_confirmation'] = "out of area";
        //                                                 }
        //                                             }
        //                                             if($jsonData['orders'][$lastindex->last_index]['payment_gateway_names'][0] != "Cash on Delivery (COD)"){
        //                                                 // $datashopify['status_confirmation'] = "confirmed";
        //                                                 $datashopify['date_confirmed'] = new Datetime();
        //                                                 $datashopify['last_status_change'] = new DateTime();
        //                                                 $datashopify['date_shipped'] = new DateTime();
        //                                                 $datashopify['ispaidapp'] = "1";
                                                        
        //                                             }
        //                                             $count = count($jsonData['orders'][$lastindex->last_index]['line_items']);
        //                                             $datashopify['market'] = 'Shopify';
        //                                             Lead::insert($datashopify);
        //                                             $incement = $lastindex->last_index + 1;
        //                                             ShopifyIntegration::where('id',$v_shopify->id)->update(['last_index' => $incement]);
        //                                             $idlead = Lead::where('n_lead',$nlead2)->first();
        //                                             for($j= 0 ; $j <= $count ; $j++ ){
        //                                                 $checksku2 = Product::where('id_user',$lastindex->id_user)->where('sku',$jsonData['orders'][$lastindex->last_index]['line_items'][$j]['sku'])->first();
        //                                                 if($checksku2){
        //                                                     $datashopify2 = array();
        //                                                     $datashopify2['id_lead'] = $idlead->id;
        //                                                     $datashopify2['id_product'] = $checksku2->id;
        //                                                     $datashopify2['quantity'] = $jsonData['orders'][$lastindex->last_index]['line_items'][$j]['quantity'];
        //                                                     if($j == 0){
        //                                                         $datashopify2['lead_value'] = (($jsonData['orders'][$lastindex->last_index]['line_items'][0]['price'] * $jsonData['orders'][$lastindex->last_index]['line_items'][0]['quantity']) - $jsonData['orders'][$lastindex->last_index]['total_discounts']);
        //                                                     }else{
        //                                                         $datashopify2['lead_value'] = $jsonData['orders'][$lastindex->last_index]['line_items'][$j]['price'] * $jsonData['orders'][$lastindex->last_index]['line_items'][$j]['quantity'];
        //                                                     }
        //                                                     if($jsonData['orders'][$lastindex->last_index]['payment_gateway_names'][0] != "Cash on Delivery (COD)"){
        //                                                         $datashopify2['date_delivred'] = new DateTime();
        //                                                     }
        //                                                     LeadProduct::insert($datashopify2);
        //                                                 }
        //                                             }
        //                                         }else{
        //                                             $incement = $lastindex->last_index + 1;
        //                                             ShopifyIntegration::where('id',$v_shopify->id)->update(['last_index' => $incement]);
        //                                         }
        //                                     }
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //             }catch(\Exception $e){
        //                 redirect()->back();
        //             }
        //         }
        //     }catch(\Exception $e){
        //         redirect()->back();
        //     }
        // })->everyFiveMinutes();
        //$schedule->command('lead::cron')->everyFiveMinutes();
        

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
