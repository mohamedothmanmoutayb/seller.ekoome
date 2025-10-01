<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sheet;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Services\GoogleSheetServices;
use Google\Service\Sheets;
use App\Models\Lead;
use App\Models\Client;
use App\Models\LeadProduct;
use Auth;
use DateTime;

class LeadCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lead:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = (new GoogleSheetServices ())->getClient();
        $client = $data;
        //dd($client);
        $sheets = Sheet::get();
        foreach($sheets as $v_sheet){
            $service = new Sheets($client);
            $spreadsheetId = $v_sheet->sheetid;
            $spreadsheetName = $v_sheet->sheetname.'!A2:L';
            //dd($spreadsheetName);
            $range = $spreadsheetName;
            $doc = $service->spreadsheets_values->get($spreadsheetId, $range);
            $response = $doc;
            for($i = 0 ; $i<20 ; $i++){
                $lastsheet = Lead::where('id_sheet',$v_sheet->id)->orderby('id','desc')->first();//dd($lastsheet->id_sheet);
                    //dd($lastsheet);
                    if($lastsheet){
                        $index = $lastsheet->index_sheet + 1;
                    }else{
                        $index = 0;
                    }
                    //dd($response['values']);
                    $last = Lead::orderby('id','DESC')->first();
                    if(empty($last->id)){
                        $kk = 1;
                    }else{
                        $kk = $last->id + 1;
                    }
                    $clients = Client::where('phone1',$response['values'][$index][5])->first();
                    if(empty($clients->phone1)){
                        $client = new Client();
                        $client->id_user = Auth::user()->id;
                        $client->id_country = $v_sheet->id_warehouse;
                        if(!empty($response['values'][$index][9])){
                            $client->city = $response['values'][$index][9];
                        }
                        if(!empty($response['values'][$index][3])){
                            $client->name = $response['values'][$index][3];
                        }
                        if(!empty($response['values'][$index][5])){
                            $client->phone1 = $response['values'][$index][5];
                        }
                        if(!empty($response['values'][$index][6])){
                            $client->phone2 = $response['values'][$index][6];
                        }
                        if(!empty($response['values'][$index][8])){
                            $client->address = $response['values'][$index][8];
                        }
                        $client->save();
                    }
                    //dd($response['values'][$index]);
                    $data = array();
                    $data['n_lead'] = $ne .''.$n.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT);
                    $data['id_sheet'] = $v_sheet->id;
                    $data['index_sheet'] = $index;
                    $data['id_user'] = $v_sheet->id_user;
                    $data['id_country'] = $v_sheet->id_warehouse;
                    $data['id_product'] = $v_sheet->id_product;
                    if(empty($clients->phone1)){
                        $data['client_id'] = $client->id;
                    }else{
                        $data['client_id'] = $clients->id;
                        $data['isdouble'] = true;
                    }
                    if(!empty($response['values'][$index][3])){
                        $data['name'] = $response['values'][$index][3];
                    }
                    if(!empty($response['values'][$index][5])){
                        $data['phone'] = '+225'. $response['values'][$index][5];
                    }
                    if(!empty($response['values'][$index][6])){
                        $data['phone2'] = '+225'. $response['values'][$index][6];
                    }
                    if(!empty($response['values'][$index][9])){
                        $data['city'] = $response['values'][$index][9];
                    }
                    if(!empty($response['values'][$index][8])){
                        $data['address'] = $response['values'][$index][8];
                    }
                    if(!empty($response['values'][$index][10])){
                        $data['lead_value'] = $response['values'][$index][10];
                    }
                    if(!empty($data['First name']) || !empty($data['phone']) || !empty($data['name'])){
                        Lead::insert($data);
                        $last_lead_hist = Lead::where('n_lead',$year .'-'.$month.'-'.$day.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT))->first();
                        $lastlead = Lead::orderby('id','DESC')->first();
                        if(!isset($lastlead->id)){
                            $lastll = 1;
                        }else{
                            $lastll = $lastlead->id;
                        }
                        $data2 = array();
                        $data2['id_lead'] = $lastll;
                        $data2['id_product'] = $v_sheet->id_product;
                        if(!empty($response['values'][$index][4])){
                            $data2['quantity'] = $response['values'][$index][4];
                        }
                        if(!empty($response['values'][$index][10])){
                            $data2['lead_value'] = $response['values'][$index][10];
                        }
                        LeadProduct::insert($data2);
                    }
            }
        }
    }
}
