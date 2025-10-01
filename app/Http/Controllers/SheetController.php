<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Services\GoogleSheetServices;
use Google\Service\Sheets;
use App\Models\Lead;
use App\Models\User;
use App\Models\Client;
use App\Models\LeadProduct;
use Auth;
use DateTime;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::join('stocks','stocks.id_product','products.id')->join('mapping_stocks','mapping_stocks.id_stock','stocks.id')->where('id_warehouse',Auth::user()->country_id)->select('products.id As id','products.name As name')->groupby('products.id','products.name')->get();
        $sheets = Sheet::with(['product','leads' => function($query){
            $query = $query->orderby('index_sheet','desc');
        }])->where('id_warehouse',Auth::user()->country_id);
        if($request->sku){
            $pro = Product::where('sku',$request->sku)->first();
            $sheets = $sheets->where('id_product',$pro->id);
        }
        if($request->product){
            $sheets = $sheets->where('id_product',$request->product);
        }
        if($request->sheet_name){
            $sheets = $sheets->where('sheetname',$request->sheet_name);
        }
        $sheets = $sheets->get();
        $sellers = User::where('id_role', '2')->get();
        //dd($products);
        return view('backend.sheets.index', compact('products','sheets','sellers'));
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
            'id_user' => Auth::user()->id,
            'id_warehouse' => Auth::user()->country_id,
            'sheetid' => $request->sheetid,
            'sheetname' => $request->sheetname,
            'created_at' => new DateTime(),
        ];

        Sheet::insert($data);
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
    public function edit(Sheet $sheet,$id)
    {
        $sheets = Sheet::where('id',$id)->first();
        return response()->json($sheets);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sheet $sheet)
    {
        $data = [
            'sheetid' => $request->sheetid,
            'sheetname' => $request->sheetname,
        ];

        Sheet::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sheet  $sheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sheet $sheet, Request $request)
    {
        Sheet::where('id',$request->id)->delete();
        return response()->json(['success'=>true]);
    }

    public function download() {
        $file_path = public_path('/importsheet.xlsx');
        return response()->download($file_path);
    }

    public function read(){
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

    public function rows(Sheet $sheet,$id)
    {
        $sheets = Lead::where('id_sheet',$id)->orderby('id','desc')->first();
        return response()->json($sheets);
    }

    public function rowsupdate(Request $request)
    {
        $data = [
            'index' => $request->rows,
        ];
        
        Sheet::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }
}
