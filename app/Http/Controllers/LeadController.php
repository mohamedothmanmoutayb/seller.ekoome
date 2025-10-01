<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lead;
use App\Models\User;
use App\Models\Citie;
use App\Models\Stock;
use App\Models\Client;
use App\Models\Upsel;
use App\Models\Sheet;
use App\Models\Zipcode;
use App\Models\Province;
use App\Models\Product;
use App\Models\Countrie;
use App\Exports\LeadsDate;
use Google\Service\Sheets;
use App\Models\Reclamation;
use App\Models\LeadProduct;
use App\Models\LeadInvoice;
use App\Models\HistoryStatu;
use App\Models\BlackList;
use Illuminate\Http\Request;
use App\Exports\LeadsExport;
use App\Events\NewLeadCreated;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\HeadingRowImport;
use App\Http\Services\GoogleSheetServices;
use App\Models\WhatsAppAccount;
use App\Models\WhatsappOffersTemplate;
use Auth;
use DateTime;
use PDF;

class LeadController extends Controller
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
        $proo = Product::where('id_country', Auth::user()->country_id)->where('id_user', Auth::user()->id)->get();
        $livraison = $request->livraison;
        $payment = $request->payment;
        $produ = $request->id_prod;
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $cities = Citie::where('id_country', Auth::user()->country_id)->limit(50)->get();
        
        $leads = Lead::with(['product','country','cities','seller'])->where('id_country',Auth::user()->country_id)->where('id_user',Auth::user()->id)->orderBy('id', 'DESC');
        
        if(!empty($customer)){
            $leads = $leads->where('name','like','%'.$customer.'%');
        }
        if(!empty($ref)){
            $leads = $leads->where('n_lead','like','%'.$ref.'%');
        }
        if($request->phone1){
            $leads = $leads->where('phone','like','%'.$request->phone1.'%');
        }
        if(!empty($phone)){
            $leads = $leads->orwhere('phone2','like','%'.$phone.'%');
        }
        if(!empty($produ)){
            $leads = $leads->where('id_product',$produ);
        }
        if($request->confirmation){
            $leads = $leads->where('status_confirmation',$request->confirmation);
        }
        if($request->market){
            $leads = $leads->where('market',$request->market);
        }
        if($request->city){
            $leads = $leads->where('id_city','like','%'.$request->city.'%');
        }
        if($livraison){
            $leads = $leads->where('status_livrison','like','%'.$livraison.'%');
        }
        if(!empty($request->date)){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            if(empty($parts[1])){
                $leads = $leads->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
            }else{
                $date_two = $parts[1];
                if($date_two == $date_from){
                    $leads = $leads->whereDate('created_at','=',date('Y-m-d' , strtotime($date_from)));
                }else{
                    $leads = $leads->whereDate('leads.created_at','>=',date('Y-m-d' , strtotime($date_from)))->whereDate('leads.created_at','<=',date('Y-m-d' , strtotime($date_two)));
                }
            }
        }
        if($payment){
            $leads = $leads->where('status_payment',$payment);
        }
        if($request->search){
            $leads = $leads->where('name','like','%'.$request->search.'%')->orwhere('phone','like','%'.$request->search.'%')->orwhere('n_lead','like','%'.$request->search.'%');
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $allLead = (clone $leads)->where('id_country', Auth::user()->country_id)->where('deleted_at', 0); 
        $count = (clone $leads)
                ->where('id_country', Auth::user()->country_id)
                ->where('deleted_at', 0)
                ->count();
        $leads = (clone $leads)
                ->where('id_country', Auth::user()->country_id)
                ->where('deleted_at', 0)
                ->paginate($items)
                ->withQueryString();
        $offerTemplates = WhatsappOffersTemplate::orderBy('name')->get();
        $whatsappAccounts = WhatsAppAccount::where('country_id', Auth::user()->id_country)->where('user_id', Auth::user()->id)->get();
        $products = Product::orderBy('name')->get();

        return view('backend.leads.index', compact('proo','cities','leads','items','count','offerTemplates','whatsappAccounts','allLead'));
    }

    public function search(Request $request)
    {
        $leads = Lead::with('country','cities')->where('id_user', Auth::user()->id)->where('id_country', Auth::user()->country_id);
        if($request->search){
            $leads = $leads->where('n_lead','like','%'.$request->search.'%')->orwhere('name','like','%'.$request->search.'%')->orwhere('phone','like','%'.$request->search.'%')->orwhere('phone2','like','%'.$request->search.'%')->orwhere('lead_value','like','%'.$request->search.'%');
        }
        
        $leads = $leads->orderBy('id', 'DESC')->where('deleted_at',0)->get();
        $counter = 1;
        $output = "";
        foreach($leads as $key => $v_lead)
        {
            $output.=
            '<tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="ids" class="custom-control-input checkBoxClass"  value="'.$v_lead['id'].'" id="pid-">
                    <label class="custom-control-label" for="pid-"></label>
                </div>
            </td>
            <td data-id="'. $v_lead['id'] .'" id="detaillead" class="detaillead" data-toggle="tooltip">'. $v_lead['n_lead'] .'</td>
            <td>';
                foreach($v_lead['product'] as $v_product){
                $output.=''. $v_product['name'] .'';
            }
                $output.='</td>
            <td data-id="'. $v_lead['id'] .'" id="detaillead" class="detaillead" data-toggle="tooltip">'. $v_lead['name'] .'</td>
            <td>';
                if(!empty($v_lead['id_city'])){
                    foreach($v_lead['cities'] as $v_city){
                      $output .=' <a> '. $v_city['name'] .'</a>';
                    }
                }else{
                    $output .=' <a> '. $v_lead['city'] .'</a>';
                }
                
            $output.='</td>';
            $output.='
            <td><a href="tel:'. $v_lead['phone'] .'">'. $v_lead['phone'] .'</a></td>
            <td>'. $v_lead['lead_value'] .'</td>';                
            $set_selected = '';
            $set_selected2 = '';
            $set_selected3 = '';
            $set_selected4 = '';
            $set_selected5 = '';
            $set_selected6 = '';
            $set_selected7 = '';
            $set_selected8 = '';
            $set_selected9 = '';
            $selected = ['new order'];
            if($v_lead['status_confirmation'] == 'new order'){
                $set_selected = 'selected';
            }elseif($v_lead['status_confirmation'] == 'confirmed'){
                $set_selected2 = 'selected';
            }elseif($v_lead['status_confirmation'] == 'no answer'){
                $set_selected3 = 'selected';
            }elseif($v_lead['status_confirmation'] =='call later' ) {
                $set_selected4 = 'selected';
            }elseif($v_lead['status_confirmation'] =='canceled' ) {
                $set_selected5 = 'selected';
            }elseif($v_lead['status_confirmation'] =='outofstock' ) {
                $set_selected6 = 'selected';
            }elseif($v_lead['status_confirmation'] =='wrong' ) {
                $set_selected7 = 'selected';
            }elseif($v_lead['status_confirmation'] =='duplicated' ) {
                $set_selected8 = 'selected';
            }elseif($v_lead['status_confirmation'] =='canceled by system' ) {
                $set_selected9 = 'selected';
            }
        //     if($v_lead['status_livrison'] != "unpacked"){
        //     $output.='
        //     <td>
        //         <form class="myform" data-id="'. $v_lead['id'] .'">
        //             <select class="form-control statu_con" id="statu_con'. $v_lead['id'] .'" data-placeholder="Select a option" name="statu_con">
        //                 <option>Select</option>
        //                 <option value="new order" '.$set_selected.'>New Order</option>
        //                 <option value="confirmed" '.$set_selected2.'>Confirmed</option>
        //                 <option value="no answer" '.$set_selected3.'>No answer</option>
        //                 <option value="call later" '.$set_selected4.'>Call later</option>
        //                 <option value="canceled" '.$set_selected5.'>Canceled</option>
        //                 <option value="outofstock" '.$set_selected6.'>Out Of Stock</option>
        //                 <option value="wrong" '.$set_selected7.'>Wrong</option>
        //                 <option value="duplicated" '.$set_selected8.'>Duplicated</option>
        //                 <option value="canceled by system" '.$set_selected9.'>Canceled By System</option>
        //             </select>
        //             <input type="hidden" class="id_lead" id="id_lead" data-id="'. $v_lead['id'] .'" value="'. $v_lead['id'] .'" />
        //         </form>
        //     </td>
        // </td>';
        // }else{
            $output.='
            <td>
            <span class="label label-warning">'. $v_lead['status_confirmation'] .'</span>
            </td>
        //     ';
        // }
        $output.='
        <td>';
            if( $v_lead['status_livrison'] == "unpacked"){
            $output .='
            <span class="label label-warning">'. $v_lead['status_livrison'] .'</span>';
            }elseif( $v_lead['status_livrison'] == "return"){
            $output .='
            <span class="label label-inverse">'. $v_lead['status_livrison'] .'</span>';
            }elseif( $v_lead['status_livrison'] == "canceld"){
            $output .='
            <span class="label label-danger">'. $v_lead['status_livrison'] .'</span>';
            }else{
            $output .='
            <span class="label label-warning">'. $v_lead['status_livrison'] .'</span>';
            }
        $output .='
        </td>
        <td>';
            $output .='
            <span class="label label-warning">'. $v_lead['status_payment'] .'</span>';
        $output .='
        </td>
            <td>'. \Carbon\carbon::parse($v_lead['created_at'])->diff(\Carbon\carbon::now())->days .'</td>
            <td>
                <a data-id="'. $v_lead['id'] .'" id="reclamations" class="text-inverse pr-2" data-toggle="tooltip" title="Reclamation"><i class="ti-marker-alt"></i></a>
            </td>
            </tr>
            ';
        }

        return response($output);
    }

    public function leadsearch(Request $request)
    {
        $leads = Lead::with('country','cities')->where('id_country', Auth::user()->country_id);
        if($request->n_lead){
            $leads = $leads->where('n_lead','like','%'.$request->n_lead.'%')->orwhere('name','like','%'.$request->n_lead.'%')->orwhere('phone','like','%'.$request->n_lead.'%')->orwhere('phone2','like','%'.$request->n_lead.'%')->orwhere('lead_value','like','%'.$request->n_lead.'%');
        }
        
        $leads = $leads->orderBy('n_lead', 'DESC')->where('deleted_at',0)->get();
        $counter = 1;
        $output = "";
        foreach($leads as $key => $v_lead)
        {
            $output.=
            '<tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="ids" class="custom-control-input checkBoxClass"  value="'.$v_lead['id'].'" id="pid-">
                    <label class="custom-control-label" for="pid-"></label>
                </div>
            </td>
            <td data-id="'. $v_lead['id'] .'" id="detaillead" class="detaillead" data-toggle="tooltip">'. $v_lead['n_lead'] .'</td>
            <td>';
                foreach($v_lead['product'] as $v_product){
                $output.=''. $v_product['name'] .'';
            }
                $output.='</td>
            <td data-id="'. $v_lead['id'] .'" id="detaillead" class="detaillead" data-toggle="tooltip">'. $v_lead['name'] .'</td>
            <td>';
                if(!empty($v_lead['id_city'])){
                    foreach($v_lead['cities'] as $v_city){
                      $output .=' <a> '. $v_city['name'] .'</a>';
                    }
                }else{
                    $output .=' <a> '. $v_lead['city'] .'</a>';
                }
                
            $output.='</td>';
            $output.='
            <td><a href="tel:'. $v_lead['phone'] .'">'. $v_lead['phone'] .'</a></td>
            <td>'. $v_lead['lead_value'] .'</td>';
                
            $set_selected = '';
            $set_selected2 = '';
            $set_selected3 = '';
            $set_selected4 = '';
            $set_selected5 = '';
            $selected = ['new order'];
            if($v_lead['status_confirmation'] == 'new order'){
                $set_selected = 'selected';
            }elseif($v_lead['status_confirmation'] == 'confirmed'){
                $set_selected2 = 'selected';
            }elseif($v_lead['status_confirmation'] == 'no answer'){
                $set_selected3 = 'selected';
            }elseif($v_lead['status_confirmation'] =='call later' ) {
                $set_selected4 = 'selected';
            }elseif($v_lead['status_confirmation'] =='canceled' ) {
                $set_selected5 = 'selected';
            }
            $output.='
            <td>
                <form class="myform" data-id="'. $v_lead['id'] .'">
                    <select class="form-control statu_con" id="statu_con'. $v_lead['id'] .'" data-placeholder="Select a option" name="statu_con">
                        <option>Select</option>
                        <option value="new order" '.$set_selected.'>New Order</option>
                        <option value="confirmed" '.$set_selected2.'>Confirmed</option>
                        <option value="no answer" '.$set_selected3.'>No answer</option>
                        <option value="call later" '.$set_selected4.'>call later</option>
                        <option value="canceled" '.$set_selected5.'>canceled</option>
                    </select>
                    <input type="hidden" class="id_lead" id="id_lead" data-id="'. $v_lead['id'] .'" value="'. $v_lead['id'] .'" />
                </form>
            </td>
            <td>'. \Carbon\carbon::parse($v_lead['created_at'])->diff(\Carbon\carbon::now())->days .'</td>
            
            <td>
                <button class="btn btn-info btn-rounded m-b-10 addreclamationgetid2" data-toggle="tooltip" data-id="'. $v_lead['id'] .'" title="reclamation"><i class="ti-marker-alt"></i></button>
                <button class="btn btn-info btn-rounded m-b-10 detaillead" data-toggle="tooltip" data-id="'. $v_lead['id'] .'" title="Edit"><i class="ti-marker-alt"></i></button>
            </td>
            </tr>
            ';
        }

        return response($output);
    }

    public function packages()
    {
        $leads = Lead::with('leadproducts','leadbyvendor')->where('status_confirmation','confirmed')->where('status_livrison','new lead')->where('id_country', Auth::user()->country_id)->where('deleted_at',0)->get()->groupby('id_product');//dd($leads);
        //dd($leads);
        return view('backend.leads.packages', compact('leads'));
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
    $products = $request->input('products', []);

    if (empty($products)) {
        return response()->json(['success' => false, 'message' => 'No products provided'], 400);
    }

    $firstProduct = collect($products)->first();

    if (!$firstProduct || !isset($firstProduct['product_id'])) {
        return response()->json(['success' => false, 'message' => 'Invalid product data'], 400);
    }

    $firstProductId = $firstProduct['product_id'];
    $firstProduct = Product::find($firstProductId);

    if (!$firstProduct) {
        return response()->json(['success' => false, 'message' => 'Invalid product'], 400);
    }

    $date = new \DateTime();
    $ne = substr(strtoupper(Auth::user()->name), 0, 1);
    $n  = substr(strtoupper(Auth::user()->name), -1);
    $last = Lead::orderBy('id', 'DESC')->first();
    $kk = $last ? $last->id + 1 : 1;
    $n_lead = $ne . $n . '-' . str_pad($kk, 5, '0', STR_PAD_LEFT);

    $lead = Lead::create([
        'n_lead'        => $n_lead,
        'id_user'       => $firstProduct->id_user,
        'id_country'    => Auth::user()->country_id,
        'name'   => $request->namecustomer,  
        'phone'  => $request->mobile,
        'phone2' => $request->mobile2,
        'id_city'=> $request->cityid, 
        'lead_value'    => $request->total, 
        'quantity'    => $request->total_quantity ,
        'market'        => 'Manual',
        'method_payment'=> 'COD',
        'id_product'    => $firstProduct->id, 
        'id_assigned'   => Auth::user()->id,
        'id_zone'       => $request->id_zone,
        'address'       => $request->address,
        'created_at'    => $date,
    ]);

    foreach ($products as $p) {
        $product = Product::find($p['product_id']);
        if (!$product) continue;

        LeadProduct::create([
            'id_lead'    => $lead->id,
            'id_product' => $product->id,
            'quantity'   => $p['quantity'] ?? 1,
            'lead_value'      => ($p['quantity'] ?? 1) * ($p['price'] ?? 0), 
        ]);
    }

    event(new NewLeadCreated($lead));

    return response()->json(['success' => true, 'lead_id' => $lead->id]);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead, Request $request, $id)
    {
        $proo = Product::where('id_country', Auth::user()->country_id)->get();
        $products = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $productss = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $product = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $provinces = Province::where('id_country', Auth::user()->country_id)->select('name','id')->get();
        $cities = Citie::where('id_country',Auth::user()->country_id)->get();
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $city = $request->city;
        $product = $request->id_prod;
        $confirmation = $request->confirmation;
        if(Auth::user()->id_role != "3"){
            $leads = Lead::where('type','seller')->with('product','leadpro','country','cities','livreur')->where('id_country', Auth::user()->country_id)->orderBy('id', 'DESC');
        }else{
            $leads = Lead::where('type','seller')->with('product','leadpro','country','cities')->where('id_assigned',null);
        }
        
        if(!empty($customer)){
            $leads = $leads->where('name',$customer);
        }
        if(!empty($ref)){
            $leads = $leads->where('n_lead',$ref);
        }
        if(!empty($phone)){
            $leads = $leads->where('phone',$phone);
        }
        if(!empty($phone)){
            $leads = $leads->where('phone2',$phone);
        }
        if(!empty($city)){
            $leads = $leads->where('id_city',$city);
        }
        if(!empty($product)){
            $leads = $leads->where('id_product',$product);
        }
        if(!empty($confirmation)){
            $leads = $leads->whereIn('status_confirmation',$confirmation);
        }
        if(Auth::user()->id_role != "3"){
            $leads= $leads->paginate(15);
        }else{
            $leads= $leads->orderby('id','asc')->limit(1)->get();//dd($leads);
            //dd($leads[0]['id']);
        }
        $date = date('Y-m-d H:i');
        //dd($date);
        $minutesToAdd = 2;
        $datemod = date('Y-m-d H:i', strtotime('+60 minutes', strtotime($date)));
        //dd($datemod);
        $lead = Lead::where('type','seller')->with('product','leadpro','country','cities')->where('id', $id)->limit(1)->first();
        //dd($lead);
        $lead = Lead::where('type','seller')->with('product','leadpro','country','cities')->where('id',$lead->id)->orderby('id','asc')->limit(1)->first();
        $detailpro = Product::where('id',$lead->id_product)->first();
        $listupsel = LeadProduct::with('product')->where('id_lead',$lead->id)->where('isupsell',1)->get();
                        
        $detailupsell = Upsel::where('id_product',$lead->id_product)->get();
        $ledproo = LeadProduct::where('isupsell',0)->where('id_lead',$lead->id)->first();
        if(!$ledproo){
            $detailpro = Product::findOrfail($lead->id_product);
        }else{
            $detailpro = Product::findOrfail($lead->id_product);
        }
        
        $productseller = Product::where('id_user',$lead->id_user)->where('id_country', Auth::user()->country_id)->get();
        $leadproduct = LeadProduct::with('product')->where('isupsell',1)->where('id_lead',$lead->id)->get();
        $allproductlead = LeadProduct::with('product')->where('id_lead',$lead->id)->get();
        $seller = User::where('id',$lead->id_user)->first();

        return view('backend.leads.leadagent', compact('seller','proo','products','productss','provinces','leads','lead','detailpro','detailupsell','listupsel','leadproduct','allproductlead','productseller','cities'));       
    }

    public function orderdetail(Request $request,$id)
    {
        $lead = Lead::with('customer')->where('id',$id)->first();//dd($lead->id);
        $user = User::where('id',$lead->id_user)->first();
        $leadproduct = LeadProduct::with('product')->where('id_lead',$lead->id)->where('isupsell','0')->get();
        $upsel = LeadProduct::with('product')->where('isupsell','1')->where('id_lead',$lead->id)->get();
        $history = HistoryStatu::where('id_lead',$lead->id)->get();
        $reclamation = Reclamation::where('id_lead',$lead->id)->get();

        return view('backend.leads.edit', compact('lead','user','leadproduct','upsel','history','reclamation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */

    public function confirmed(Request $request)
    {
        $data = array();
        $data['name'] = $request->customename;
        $data['phone'] = $request->customerphone;
        $data['phone2'] = $request->customerphone;
        $data['id_city'] = $request->customercity;
        $data['id_zone'] = $request->customerzone;
        $data['address'] = $request->customeraddress;
        $data['lead_value'] = $request->leadvalue;
        $data['note'] = $request->commentdeliv;
        $data['status_confirmation'] = "confirmed";
        if(!empty($request->datedelivred)){
            $data['date_confirmed'] = $request->datedelivred;
            $data['date_delivred'] = $request->datedelivred;
            $data['date_picking'] = $request->datedelivred;
        }else{
            $data['date_confirmed'] = new DateTime();
            $data['date_delivred'] = new DateTime();
            $data['date_picking'] = new DateTime();
        }
        $data['note'] = $request->commentdeliv;

        Lead::where('id',$request->id)->update($data);
        LeadProduct::where('id_lead',$request->id)->update(['date_delivred' => new DateTime()]);
        $data2 = [
            'id_lead' => $request->id,
            'country_id' => Auth::user()->country_id,
            'id_user' => Auth::user()->id,
            'status' => "confirmed",
            'comment' => $request->commentdeliv,
            'date' => new DateTime(),
        ];
        historyStatu::insert($data2);
        $data3 = array();
        $data3['id_lead'] = $request->id;
        $data3['id_user'] = Auth::user()->id;
        $data3['country_id'] = Auth::user()->country_id;
        $data3['status'] = "unpacked";
        $data3['comment'] = "unpacked";
        $data3['date'] = new DateTime();
        
        historyStatu::insert($data3);
        return response()->json(['success'=>true]);
    }

    public function canceled(Request $request)
    {
        
        $data = [
            'status_confirmation' => "canceled",
            'note' => $request->commentecanceled,
        ];

        Lead::where('id',$request->id)->update($data);
        LeadProduct::where('id_lead',$request->id)->update(['date_delivred' => Null]);
        $data2 = [
            'id_lead' => $request->id,
            'id_user' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'status' => "canceled",
            'comment' => $request->commentecanceled,
            'date' => new DateTime(),
        ];
        historyStatu::insert($data2);
        return response()->json(['success'=>true]);
    }

    public function wrong(Request $request)
    {
        
        $data = [
            'status_confirmation' => "wrong",
            'note' => $request->commentecanceled,
        ];

        Lead::where('id',$request->id)->update($data);
        LeadProduct::where('id_lead',$request->id)->update(['date_delivred' => Null]);
        $data2 = [
            'id_lead' => $request->id,
            'id_user' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'status' => "wrong",
            'comment' => $request->commentecanceled,
            'date' => new DateTime(),
        ];
        historyStatu::insert($data2);
        return response()->json(['success'=>true]);
    }

    public function leadwrong(Request $request)
    {
        $proo = Product::where('id_country', Auth::user()->country_id)->get();
        $products = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $productss = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $product = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $cities = Citie::where('id_country', Auth::user()->country_id)->get();
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $city = $request->city;
        $product = $request->id_prod;
        $confirmation = $request->confirmation;
        $leads = Lead::with('product','leadpro','country','cities','livreur')->where('status_confirmation','wrong')->where('id_country', Auth::user()->country_id)->orderBy('id', 'DESC');
        
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        if(!empty($customer)){
            $leads = $leads->where('name',$customer);
        }
        if(!empty($ref)){
            $leads = $leads->where('n_lead',$ref);
        }
        if(!empty($phone)){
            $leads = $leads->where('phone','like','%'.$phone.'%');
        }
        if(!empty($phone)){
            $leads = $leads->where('phone2','like','%'.$phone.'%');
        }
        if(!empty($city)){
            $leads = $leads->where('id_city',$city);
        }
        if(!empty($product)){
            $leads = $leads->where('id_product',$product);
        }
        if(!empty($confirmation)){
            $leads = $leads->whereIn('status_confirmation',$confirmation);
        }
        if(!empty($request->date)){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            $leads = $leads->whereBetween('created_at', [$date_from , $date_two]);
        }
        $leads= $leads->where('deleted_at',0)->paginate($items);
        $type = "Wrong Data";
        return view('backend.leads.index', compact('proo','products','productss','cities','leads','items','type'));

    }

    public function duplicated(Request $request,$id)
    {
        $checklead = Lead::where('id',$id)->where('status_livrison','unpacked')->first();
        if($checklead){
            $data = [
                'status_confirmation' => "duplicated",
                'status_livrison' => "unpacked",
                'last_status_change' => new DateTime(),
                'status' => '0',
                'id_assigned' => Auth::user()->id,
                'last_contact' => new DateTime(),
                'date_delivred' => Null,
            ];

            Lead::where('id',$id)->update($data);
            $data2 = [
                'id_lead' => $id,
                'id_user' => Auth::user()->id,
                'country_id' => Auth::user()->country_id,
                'status' => "duplicated",
                'comment' => 'duplicated',
                'date' => new DateTime(),
            ];
            historyStatu::insert($data2);
            $datta = array();
            $datta['date_delivred'] = Null;
            $datta['livrison'] = "unpacked";
            $datta['outstock'] = "0";
            LeadProduct::where('id_lead',$id)->update($datta);
            return back();
        }
    }

    public function horzone($id)
    {
        $checklead = Lead::where('id',$id)->where('status_livrison','unpacked')->first();
        if($checklead){
            $data = [
                'status_confirmation' => "out of area",
                'status_livrison' => "unpacked",
                'last_status_change' => new DateTime(),
                'status' => '0',
                'id_assigned' => Auth::user()->id,
                'last_contact' => new DateTime(),
                'date_delivred' => Null,
            ];

            Lead::where('id',$id)->update($data);
            $data2 = [
                'id_lead' => $id,
                'id_user' => Auth::user()->id,
                'country_id' => Auth::user()->country_id,
                'status' => "out of area",
                'comment' => 'out of area',
                'date' => new DateTime(),
            ];
            historyStatu::insert($data2);
            $datta = array();
            $datta['date_delivred'] = Null;
            $datta['livrison'] = "unpacked";
            $datta['outstock'] = "0";
            LeadProduct::where('id_lead',$id)->update($datta);
            return back();
        }
    }

    public function outofstock(Request $request)
    {
        $leadnull = Lead::with('leadproduct')->where('status_livrison','unpacked')->orderby('id','desc')->get();//dd($leadnull);
        foreach($leadnull as $v_null){
            if($v_null['leadproduct']->isEmpty()){
                $data = array();
                $data['id_lead'] = $v_null->id;
                $data['id_product'] = $v_null->id_product;
                $data['lead_value'] = $v_null->lead_value;
                $data['quantity'] = $v_null->quantity;
                LeadProduct::insert($data);
            }
        }
        $neworder = Lead::where('status_confirmation','new order')->where('status_livrison','unpacked')->get();
        $proo = Product::where('id_country', Auth::user()->country_id)->get();
        $products = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $productss = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $product = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $cities = Citie::where('id_country', Auth::user()->country_id)->get();
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $city = $request->city;
        $product = $request->id_prod;
        $confirmation = $request->confirmation;
        $leads = Lead::with('product','leadpro','country','cities','livreur')->where('status_confirmation','outofstock')->where('id_country', Auth::user()->country_id)->orderBy('id', 'DESC');
        
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        if(!empty($customer)){
            $leads = $leads->where('name',$customer);
        }
        if(!empty($ref)){
            $leads = $leads->where('n_lead',$ref);
        }
        if(!empty($phone)){
            $leads = $leads->where('phone','like','%'.$phone.'%');
        }
        if(!empty($phone)){
            $leads = $leads->where('phone2','like','%'.$phone.'%');
        }
        if(!empty($city)){
            $leads = $leads->where('id_city',$city);
        }
        if(!empty($product)){
            $leads = $leads->where('id_product',$product);
        }
        if(!empty($confirmation)){
            $leads = $leads->whereIn('status_confirmation',$confirmation);
        }
        if(!empty($request->date)){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            $leads = $leads->whereBetween('created_at', [$date_from , $date_two]);
        }
        $leads= $leads->where('deleted_at',0)->paginate($items);

        $type = "Out of Stock";
        return view('backend.leads.index', compact('proo','products','productss','cities','leads','items','type'));
    }

    public function details($id)
    {
        // $lead = LeadProduct::with('product','leads')->where('id_lead',$id)->get();
        // $products = LeadProduct::where('id_lead',$id)->get();
        $lead = Lead::with('leadproduct','product','seller')->where('id',$id)->first();
        $history = HistoryStatu::where('id_lead',$lead->id)->get();
        $reclamation = Reclamation::where('id_lead',$lead->id)->get();
        // dd($lead);
        return view('backend.leads.details', compact('lead','history','reclamation'));
    }

    public function seacrhdetails($id)
    {   
        $leadss = Lead::where('id','like','%'.$id.'%')->orwhere('n_lead','like','%'.$id.'%')->first();
        //$products = LeadProduct::where('id_lead',$leadss->id)->first();
        //dd($leadss->name);
        $leads = json_decode($leadss);
        return response()->json($leads);
    }

    public function detailspro($id)
    {
        $leadss = Lead::where('id',$id)->first();
        //dd($id);
        $empData['data'] = Product::where('id_user',$leadss->id_user)->select('id','name')->get();
        return response()->json($empData);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = [
            'name' => $request->namecustomer,
            'quantity' => $request->quantity,
            'phone' => $request->mobile,
            'phone2' => $request->mobile2,
            'id_city' => $request->cityid,
            'id_zone' => $request->zoneid,
            'address' => $request->address,
            'lead_value' => $request->total,
            'note' => $request->note,
        ];

        Lead::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Lead $lead)
    {
        $ids = $request->ids;
        //dd($ids);
        foreach($ids as $v_id){
            Lead::where('id',explode(",",$v_id))->update(['deleted_at' => 1]);
            // $lea = Lead::where('id',explode(",",$v_id))->first();
            // $count = Lead::where('id_order',$lea->id_order)->where('id_user',$lea->id_user)->where('id_country', $lea->id_country)->count();
            // if($count >= 2){
            //     Lead::where('id',explode(",",$v_id))->where('status_confirmation','duplicated')->delete();
            // }
            // Lead::where('id',explode(",",$v_id))->delete();
        }//dd('yyyy');
        return response()->json(['success'=>true]);
    }
    
    public function forceDelete(Request $request)
    {
        Lead::where('id',$request->id)->delete();
        LeadProduct::where('id_lead',$request->id)->delete();
        return response()->json(['success'=>true]);
    }
    public function statuscon(Request $request)
    {
        $data = [
            'status_confirmation' => $request->status,
            'last_status_change' => new DateTime(),
            'last_contact' => new DateTime(),
        ];

        Lead::where('id',$request->id)->update($data);
        $data3 = array();
        $data3['date_delivred'] = new DateTime();
        LeadProduct::where('id_lead',$request->id)->update($data3);
        
        if($request->status == "confirmed"){
            LeadProduct::where('id_lead',$request->id)->update(['date_delivred' => new DateTime()]);
        }
        $data2 = [
            'id_lead' => $request->id,
            'id_user' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'status' => $request->status,
        ];
        HistoryStatu::insert($data2);
        return response()->json(['success'=>true]);
    }

    public function Upselldetails(Request $request)
    {
        $leads = Lead::where('id',$request->id)->first();
        $upsell = Product::with('upselles')->where('id', $leads->id_product)->get();
        //dd($leads);
        $upsell = json_decode($upsell);
        return response()->json($upsell);
    }

    public function date(Request $request)
    {
        $data = [
            'date_delivred' => $request->date,
        ];

        Lead::where('id',$request->id)->update($data);
        $data2 = [
            'id_lead' => $request->id,
            'id_user' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'status' => "confirmed",
            'date' => $request->date,
        ];
        HistoryStatu::insert($data2);

        $data3 = array();
        $data3['id_lead'] = $request->id;
        $data3['id_user'] = Auth::user()->id;
        $data3['country_id'] = Auth::user()->country_id;
        $data3['status'] = "unpacked";
        $data3['comment'] = "unpacked";
        $data3['date'] = new DateTime();
        
        historyStatu::insert($data3);
        return response()->json(['success'=>true]);
    }

    public function upsellstore(Request $request)
    {
        $data = [
            'id_lead' => $request->id,
            'isupsell' => '1',
            'id_product' => $request->product,
            'quantity' => $request->quantity,
            'lead_value' => $request->price,
        ];

        LeadProduct::insert($data);
        return response()->json(['success'=>true]);
    }

    public function multiupsell(Request $request)
    {
        //dd($request->quantity);
        $data = $request->quantity;
        foreach($data as $item => $v_data){
            //dd($request->id);
            $data = [
                'id_lead' => $request->id,
                'isupsell' => '0',
                'isupselle_seller' => '1',
                'id_product' => $request->product[$item],
                'quantity' => $request->quantity[$item],
                'lead_value' => $request->price[$item],
            ];
            //dd($data);
            LeadProduct::insert($data);
        }
            $lead = Lead::where('type','seller')->where('id',$request->id)->first();
            $data2 = [
                'lead_value' => LeadProduct::where('id_lead',$request->id)->sum('lead_value') ,
                'quantity' => LeadProduct::where('id_lead',$request->id)->sum('quantity') ,
            ];
            Lead::where('type','seller')->where('id',$request->id)->update($data2);
        //
        //
        return response()->json(['success'=>true]);
    }


    public function settings()
    {
        return view('backend.leads.settings');
    }

    public function notestatus(Request $request)
    {
        $status = Lead::where('id',$request->id)->first();
        $data = [
            'id_lead' => $request->id,
            'id_user' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'status' => $status->status_confirmation,
            'comment' => $request->comment,
            'date' => $request->date,
        ];

        HistoryStatu::insert($data);
        if($status->status_confirmation == "confirmed"){
            $data3 = array();
            $data3['id_lead'] = $request->id;
            $data3['id_user'] = Auth::user()->id;
            $data3['country_id'] = Auth::user()->country_id;
            $data3['status'] = "unpacked";
            $data3['comment'] = "unpacked";
            $data3['date'] = new DateTime();
            
            historyStatu::insert($data3);
        }
        return response()->json(['success'=>true]);
    }

    public function statusc(Request $request)
    {
        $data2 = [
            "status_confirmation" => $request->status,
        ];
        Lead::where('id',$request->id)->update($data2);
        $status = Lead::where('id',$request->id)->first();
        $data = [
            'id_lead' => $status->id,
            'id_user' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'status' => $status->status,
            'comment' => $request->status,
            'date' => new DateTime(),
        ];

        HistoryStatu::insert($data);

        if($status->status_confirmation == "confirmed"){
            $data3 = array();
            $data3['id_lead'] = $request->id;
            $data3['id_user'] = Auth::user()->id;
            $data3['country_id'] = Auth::user()->country_id;
            $data3['status'] = "unpacked";
            $data3['comment'] = "unpacked";
            $data3['date'] = new DateTime();
            
            historyStatu::insert($data3);
        }
        return response()->json(['success'=>true]);
    }

    public function history(Request $request)
    {
        $history = HistoryStatu::with(['lead:id,n_lead','delivery','agent'])->where('id_lead', $request->id)
        ->orderBy('created_at', 'DESC')
        ->get(['id_lead', 'status', 'comment', 'created_at']);
        return response($history);
    }
    //info upsell
    public function infoupsell($id)
    {
        $lead = Lead::where('id',$id)->first();
        $info = Upsel::where('id_product',$lead->id_product)->get();
        $output = "";
        foreach($info as $v_info){
            $output .='
                <tr>
                    <td>'. $v_info->quantity .'</td>
                    <td>'. $v_info->discount .'</td>
                    <td>'. $v_info->note .'</td>
                </tr>
            ';
        }
        return response($output);
        
    }

    //payment using app

    public function paymentapp(Request $request)
    {
        $checklead = Lead::where('id',$request->id)->where('status_confirmation','confirmed')->where('status_livrison','unpacked')->first();
        if($checklead){
            $data = [
                'status_confirmation' => "confirmed",
                'status_payment' => "prepaid",
                'status_livrison' => "unpacked",
                'note_payment' => $request->note,
                'ispaidapp' => "1",
                'date_delivred' => new DateTime(),
            ];
            Lead::where('id',$request->id)->update($data);
            $dat = array();
            $dat['date_delivred'] = new DateTime();
            LeadProduct::where('id_lead',$request->id)->update($dat);
            $data2 = [
                'id_lead' => $request->id,
                'id_user' => Auth::user()->id,
                'country_id' => Auth::user()->country_id,
                'status' => "prepaid",
                'comment' => $request->note,
                'date' => new DateTime(),
            ];

            HistoryStatu::insert($data2);
            
            $data3 = array();
            $data3['id_lead'] = $request->id;
            $data3['id_user'] = Auth::user()->id;
            $data3['country_id'] = Auth::user()->country_id;
            $data3['status'] = "unpacked";
            $data3['comment'] = "unpacked";
            $data3['date'] = new DateTime();
            
            historyStatu::insert($data3);

            return response()->json(['success'=>true]);
        }else{
            return response()->json(['error'=>false]);
        }
        
    }

    public function customers()
    {
        $countries = Countrie::get();
        $cities = Citie::get();
        $products = Stock::with('products')->get();
        $productss = Stock::with('products')->get();
        $leads = LeadProduct::with('product')->get()->groupby(['id_product']['id_lead']);//dd($leads);
        return view('backend.leads.customers', compact('leads','countries','cities','products','productss'));
    }

    public function export(Request $request)
    {
        $ids = $request->ids;
        foreach($ids as $v_id){
            $data[] = Lead::whereIn('id',explode(",",$v_id))->get();
        }
    }

    public function download(Request $request,$leads)
    {
        $leads = json_decode($leads);
        $leads = new LeadsExport([$leads]);
        return Excel::download($leads, 'Leads.xlsx');
    }

    public function export2(Request $request)
    {
        $date = $request->date;
        $id = $request->id;
        $parts = explode(' - ' , $request->date);
        $date_from = $request->date;
        return response()->json([$date_from  , $id]);
    }

    public function download2(Request $request,$leads)
    {   
        
        $parts = explode(' to ' , $leads);
        $date_from = str_replace(",", "",$parts[0]);
        if(sizeof($parts)>1){
            $date_two = str_replace(",", "",$parts[1]);
        }else{
            $date_two = '';
        }
        $id = $date_two;      
        $leads = new LeadsDate([$date_from , $date_two , $id]);       
        return Excel::download($leads, 'Leads.xlsx');
    }

    public function call(Request $request)
    {
        $new = new DateTime();
        $data = [
            'status_confirmation' => "call later",
            'date_call' => $request->date .' '. $request->time,
            'note' => $request->comment,
            'last_status_change' => new DateTime(),
            'status' => '0',
        ];
        Lead::where('id',$request->id)->update($data);
        LeadProduct::where('id_lead',$request->id)->update(['date_delivred' => Null]);
        
        $data2 = [
            'id_lead' => $request->id,
            'id_user' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'status' => "call later",
            'comment' => $request->comment,
            'date' => $request->date,
        ];
        HistoryStatu::insert($data2);
        return response()->json(['success'=>true]);
    }

    //deleted upsell

    public function deleteupsell($id)
    {
        $upsell = LeadProduct::where('id',$id)->first();
        $lead = Lead::where('id',$upsell->id_lead)->first();
        $data = array();
        $data['quantity'] = $lead->quantity - $upsell->quantity;
        $data['lead_value'] = $lead->lead_value - $upsell->lead_value;
        Lead::where('id',$lead->id)->update($data);
        LeadProduct::where('id',$upsell->id)->delete();
        return redirect()->back();
    }

    //update price

    public function updateprice(Request $request)
    {
        $data = array();
        $data['lead_value'] = $request->leadvalue;
        $data['quantity'] = $request->quantity;
        $data['id_product'] = $request->product;

        LeadProduct::where('isupsell',0)->where('id_lead',$request->id)->update($data);
        $price = LeadProduct::where('id_lead',$request->id)->sum('lead_value');
        $quantity = LeadProduct::where('id_lead',$request->id)->sum('quantity');
        $data2 = array();
        $data2['lead_value'] = $price;
        $data2['quantity'] = $quantity;
        Lead::where('id',$request->id)->update($data2);

        $leads = Lead::where('id',$request->id)->first();
        $leads = json_decode($leads);
        return response()->json($leads);
    }

    public function another(Request $request)
    {
        $neworder = Lead::whereIn('status_confirmation',['no answer','call later'])->where('id_country', Auth::user()->country_id)->where('deleted_at',0)->get();
        $proo = Product::where('id_country', Auth::user()->country_id)->get();
        $products = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $productss = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $product = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $cities = Citie::where('id_country', Auth::user()->country_id)->get();
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $city = $request->city;
        $product = $request->id_prod;
        $confirmation = $request->confirmation;
        $leads = Lead::with('product','leadpro','country','cities','livreur')->whereIn('status_confirmation',['no answer','call later'])->where('id_country', Auth::user()->country_id)->where('deleted_at',0)->orderBy('id', 'DESC');
        
        if(!empty($customer)){
            $leads = $leads->where('name',$customer);
        }
        if(!empty($ref)){
            $leads = $leads->where('n_lead',$ref);
        }
        if(!empty($phone)){
            $leads = $leads->where('phone',$phone);
        }
        if(!empty($phone)){
            $leads = $leads->where('phone2',$phone);
        }
        if(!empty($city)){
            $leads = $leads->where('id_city',$city);
        }
        if(!empty($product)){
            $leads = $leads->where('id_product',$product);
        }
        if(!empty($confirmation)){
            $leads = $leads->whereIn('status_confirmation',$confirmation);
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        $leads= $leads->paginate($items);
        
        $date = date('Y-m-d H:i');
        //dd($date);
        $minutesToAdd = 2;
        $datemod = date('Y-m-d H:i', strtotime('+60 minutes', strtotime($date)));
        //dd($datemod);
        
        return view('backend.leads.author', compact('proo','products','productss','cities','leads','items'));
        
    }

    //print label

    public function print(Request $request,$id)
    {
            $leads[] = Lead::with(['leadproduct' => function($query){
                $query = $query->with('product');
            }],['cities'],['leadbyvendor'],['zones'])->where('id',$id)->get();
            $customPaper = array(0,0,370,330);
            $pdf = PDF::loadView('backend.leads.label', compact('leads'))->setPaper($customPaper,'portrait');
            return $pdf->stream();

    }

    public function reload()
    {
        $leads = Lead::where('status_confirmation','new order')->where('status','1')->where('created_at', '<', Carbon::now()->subday(1))->get();
        foreach($leads as $v_lead){
            Lead::where('id',$v_lead->id)->update(['status' => '0']);
        }
        return redirect()->back();
    }

    public function refresh($id)
    {
        $data = (new GoogleSheetServices ())->getClient();
        $client = $data;
        //dd($client);
        
            $info = Lead::where('id',$id)->first();
            try{
                $v_sheet = Sheet::where('id',$info->id_sheet)->first();//dd($info);
                $userss = User::where('id',$info->id_user)->first();
                $ne = substr(strtoupper($userss->name), 0 , 1);
                $n = substr(strtoupper($userss->name), -1);
                $service = new Sheets($client);
                $spreadsheetId = $v_sheet->sheetid;
                $spreadsheetName = $v_sheet->sheetname.'!A2:L';
                //dd($spreadsheetName);
                $range = $spreadsheetName;
                $doc = $service->spreadsheets_values->get($spreadsheetId, $range);
                $response = $doc;
                $lastsheet = Lead::where('id',$id)->orderby('id','desc')->first();//dd($lastsheet->id_sheet);
                //dd($lastsheet);
                if($lastsheet){
                    $index = $lastsheet->index_sheet;
                }
                $last = Lead::orderby('id','DESC')->first();
                if(empty($last->id)){
                    $kk = 1;
                }else{
                    $kk = $last->id + 1;
                }//dd($v_sheet->id);
                 //dd($response['values'][$index][4]);
                $countries = Countrie::where('id',$v_sheet->id_warehouse)->first();
                        
                $data = array();
                if(!empty($response['values'][$index][0])){
                    $data['id_order'] = $response['values'][$index][0];
                }
                $data['id_product'] = $v_sheet->id_product;
                if(!empty($response['values'][$index][2])){
                    $data['name'] = $response['values'][$index][2];
                }
                if(!empty($response['values'][$index][4])){
                    $data['phone'] = $countries->negative. $response['values'][$index][4];
                }
                if(!empty($response['values'][$index][5])){
                    $data['phone2'] = $countries->negative. $response['values'][$index][5];
                }
                if(!empty($response['values'][$index][8])){
                    $data['city'] = $response['values'][$index][8];
                }
                if(!empty($response['values'][$index][7])){
                    $data['address'] = $response['values'][$index][7];
                }
                if(!empty($response['values'][$index][9])){
                    $data['lead_value'] = $response['values'][$index][9];
                }
                if(!empty($data['First name']) || !empty($data['phone']) || !empty($data['name']) || !empty($response['values'][$index][4])){
                    Lead::where('id',$id)->update($data);
                            
                    $data2 = array();
                    $data2['id_product'] = $v_sheet->id_product;
                    if(!empty($response['values'][$index][3])){
                        $data2['quantity'] = $response['values'][$index][3];
                    }
                    if(!empty($response['values'][$index][9])){
                        $data2['lead_value'] = $response['values'][$index][9];
                    }
                    LeadProduct::where('id_lead',$id)->update($data2);
                }

            }catch(\Exception $e){
                $checkleadproduct = LeadProduct::where('id_lead',$id)->first();
                if(empty($checkleadproduct)){
                    $data = array();
                    $data['id_lead'] = $info->id;
                    $data['id_product'] = $info->id_product;
                    $data['quantity'] = $info->quantity;
                    $data['lead_value'] = $info->lead_value;
                    LeadProduct::insert($data);
                }
                return redirect()->back();
            }
            return redirect()->route('leads.index');
                
    }

    public function upload(Request $request)
    {
        $the_file  = $request->file('upload_file');
        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'A', $column_limit );
            $startcount = 2;
            
            $startDate = strtotime('2025-03-01');
            foreach ( $row_range as $row ) {
             //remove space from phone
                $sku = trim($sheet->getCell( 'B' . $row )->getValue());
                $rowsPerDate = 100;
                $cot = 0;
                if($cot == 100){
                    $date = strtotime('+1 day', $startDate);
                }
                 $product = Product::where('sku',$sku)->first();
                 if(!empty($product)){
                     $date = date('Y-m-d');
                     $checkorderexist = Lead::where('id_order',$sheet->getCell( 'A' . $row )->getValue())
                                             ->where('phone',$sheet->getCell( 'J' . $row )->getValue())  
                                             ->where('id_user',$product->id_user)                                       
                                             ->whereDate('created_at', $date)
                                             ->where('id_country',Auth::user()->country_id)
                                             ->where('deleted_at',0)->first();
                    
                     // if(!empty($checkorderexist)){
                         // if($checkorderexist->id_product == $product->id){
                         //     continue;
                         // }
                     // }
                     if(empty($checkorderexist)){
                         $user = User::where('id',$product->id_user)->first();
                         $ne = substr(strtoupper($user->name), 0 , 1);
                         $n = substr(strtoupper($user->name), -1);
                         $last = Lead::orderby('id','DESC')->first();
                         if(!isset($last->id)){
                             $kk = 1;
                         }else{
                             $kk = $last->id + 1;
                         }
                         $n_lead = $ne .''.$n.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT);
                         $data = array();
                         $data['id_order'] = $sheet->getCell( 'A' . $row )->getValue();
                         $data['n_lead'] = $n_lead;
                         $data['id_user'] = $user->id;
                         $data['id_country'] = $product->id_country;
                         $data['method_payment'] = "COD";
                         $data['type'] = "seller";
                         $data['name'] = $sheet->getCell( 'E' . $row )->getValue();
                         $data['address'] = $sheet->getCell( 'F' . $row )->getValue();
                         $data['city'] = $sheet->getCell( 'G' . $row )->getValue();
                         $data['province'] = $sheet->getCell( 'H' . $row )->getValue();
                         $data['zipcod'] = trim($sheet->getCell( 'I' . $row )->getValue());
                         $data['phone'] = $sheet->getCell( 'J' . $row )->getValue();
                         $data['email'] = $sheet->getCell( 'L' . $row )->getValue();
                         $data['note'] = $sheet->getCell( 'M' . $row )->getValue();
                         $data['quantity'] = $sheet->getCell( 'C' . $row )->getValue();
                         $data['id_product'] = $product->id;
                         $data['market'] = 'YouCan';
                         $leadvalue = $sheet->getCell( 'D' . $row )->getValue();
                         if(str_contains($leadvalue, ','))
                         {
                             $leadvalue = str_replace(',', '.', $sheet->getCell( 'D' . $row )->getValue());
                         }
                         if (preg_match('/\d+(\.\d+)?/', $leadvalue, $matches)) {
                             $leadvalue = $matches[0];
                         } 
                         $data['lead_value'] = $leadvalue;
                         $checkduplicated = Lead::where('phone',$sheet->getCell( 'J' . $row )->getValue())
                                         ->where('id_product',$product->id)
                                         ->whereDate('created_at',$date)
                                         ->where('deleted_at',0)->count();
                         if($checkduplicated != 0){
                             $data['status_confirmation'] = "duplicated"; 
                         }
                         if(Zipcode::where('name', $sheet->getCell( 'I' . $row )->getValue())->where('id_country',$product->id_country)->count() != 0){
                             $data['status_confirmation'] = "out of area"; 
                         }
                         if($product->id_country == "12"){
                             if(Zipcode::where('id_country',$product->id_country)->where('name', 'like','%'.substr($data['zipcod'] , 0 , 4).'%')->count() != 0){
                                 $data['status_confirmation'] = "out of area";
                             }
                         }
                         // if(!empty(strtoupper($sheet->getCell( 'N' . $row )->getValue())) !=  "COD"){
                         //     $data['status_confirmation'] = "confirmed";
                         //     $data['last_contact'] = new DateTime();
                         //     $data['ispaidapp'] = "1";
                         //     $data['method_payment'] = "PREPAID";
                         //     $data['date_shipped'] = new DateTime();
                         //     $data['date_confirmed'] = new DateTime();
                         //     $data['date_picking'] = new DateTime();
                         // }
                         if(strtoupper($sheet->getCell( 'N' . $row )->getValue()) ==  "PREPAID"){
                             // $data['status_confirmation'] = "confirmed";                        
                             $data['ispaidapp'] = "1";
                             $data['method_payment'] = "PREPAID";
                         }
                         $data['status_confirmation'] = $sheet->getCell( 'O' . $row )->getValue();
                         if($sheet->getCell( 'N' . $row )->getValue() == "confirmed"){
                            $data['status_livrison'] = $sheet->getCell( 'P' . $row )->getValue();
                            $data['status_payment'] = $sheet->getCell( 'Q' . $row )->getValue();
                            $data['date_confirmed'] = $date;
                            $data['date_picking'] = strtotime('+2 day', $date);
                            $data['date_delivred'] = strtotime('+4 day', $date);
                         }
                         Lead::insert($data);
 
                         $lastid = Lead::where('n_lead',$n_lead)->first();
                         $data2 = array();
                         $data2['id_lead'] = $lastid->id;
                         $data2['id_product'] = $lastid->id_product;
                         $data2['quantity'] = $lastid->quantity;
                         $data2['lead_value'] = $lastid->lead_value;
                         $data2['created_at'] = $date;
                         // if(!empty(strtoupper($sheet->getCell( 'N' . $row )->getValue())) != "COD"){
                         //     $data2['date_delivred'] = new DateTime();
                         // }
                         if(strtoupper($sheet->getCell( 'N' . $row )->getValue()) ==  "PREPAID"){
                             // $data2['date_delivred'] = new DateTime();
                         }
                         LeadProduct::insert($data2);

                         $history = array();
                         $history['id_lead'] = $lastid->id;
                         $history['status'] = "new order";
                         $history['created_at'] = $date;
                         HistoryStatu::insert($history);

                         $history2 = array();
                         $history2['id_lead'] = $lastid->id;
                         $history2['status'] = $lastid->status_confirmation;
                         $history2['created_at'] = $date;
                         HistoryStatu::insert($history2);
                         
                         if($lastid->status_confirmation == "confirmed"){
                            $history3 = array();
                            $history3['id_lead'] = $lastid->id;
                            $history3['status'] = $lastid->status_livrison;
                            $history3['created_at'] = $lastid->date_delivred;
                            HistoryStatu::insert($history3);
                         }
                         

                         


                     }else{
                         
                         $product = Product::where('sku',$sheet->getCell( 'B' . $row )->getValue())->first();
                         $data2 = array();
                         $data2['id_lead'] = $checkorderexist->id;
                         $data2['id_product'] = $product->id;
                         $data2['quantity'] = $sheet->getCell( 'C' . $row )->getValue();
                         $leadvalue = $sheet->getCell( 'D' . $row )->getValue();
                         if(str_contains($leadvalue, ','))
                         {
                             $leadvalue = str_replace(',', '.', $sheet->getCell( 'D' . $row )->getValue());
                         }
                         if (preg_match('/\d+(\.\d+)?/', $leadvalue, $matches)) {
                             $leadvalue = (float)$matches[0];
                         } 
                         $data2['lead_value'] = $leadvalue;
                         $checkorderexist->lead_value = $checkorderexist->lead_value + $leadvalue;
                         $checkorderexist->quantity = $checkorderexist->quantity + $sheet->getCell( 'C' . $row )->getValue();
                         $checkorderexist->save();
                         LeadProduct::insert($data2);
 
                     }
                 }
                 $startcount++;
             }
             $the_file  = $request->file('upload_file');
 
             $userName = auth()->user()->name;
     
             $filename = $userName . '_' . date('Y-m-d H:i'). '.' .$the_file->getClientOriginalExtension();
     
             $the_file->move(storage_path('app/uploads'), $filename);
             
         } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->withErrors('There was a problem uploading the data!');
         }
       return back()->with('success', 'Excel Data Imported successfully.');
    }

    public function uploadstatus(Request $request)
    {
        $the_file  = $request->file('upload_file');
        try{
           $spreadsheet = IOFactory::load($the_file->getRealPath());
           $sheet        = $spreadsheet->getActiveSheet();
           $row_limit    = $sheet->getHighestDataRow();
           $column_limit = $sheet->getHighestDataColumn();
           $row_range    = range( 2, $row_limit );
           $column_range = range( 'A', $column_limit );
           $startcount = 2;
           //dd($row_range);
           foreach ( $row_range as $row ) {
                $lead = Lead::where('numEnvio',$sheet->getCell( 'A' . $row )->getValue())->count();
                if($lead == 1){
                    $leadd = Lead::where('numEnvio',$sheet->getCell( 'A' . $row )->getValue())->first();
                        if($sheet->getCell( 'B' . $row )->getValue() == "EN ARRASTRE" || $sheet->getCell( 'B' . $row )->getValue() == "TRAMO ORIGEN" || $sheet->getCell( 'B' . $row )->getValue() == "TRANSITO" || $sheet->getCell( 'B' . $row )->getValue() == "DELEGACION DESTINO" || $sheet->getCell( 'B' . $row )->getValue() == "TRAMO DESTINO" || $sheet->getCell( 'B' . $row )->getValue() == "NUEVO REPARTO" || $sheet->getCell( 'B' . $row )->getValue() == "NO LOCALIZADO" || $sheet->getCell( 'B' . $row )->getValue() == "TRANSFERIDO PROVEEDOR" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/TRANSITO" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/DELEGACION" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/EN REPARTO" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/SIN RECEPCION" || $sheet->getCell( 'B' . $row )->getValue() == "RECEPCIONADO EN OFICINA" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/CESION ALM. ADUANA" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/ARRASTRE" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/MAL TRANSITADO" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/DELEGACION ORIGEN" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/DELEGACION DESTINO" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/NUEVO REPARTO"){
                            $data['status_livrison'] = "in transit";
                        }
                        if($sheet->getCell( 'B' . $row )->getValue() == "SIN RECEPCION"){
                            $data['status_livrison'] = "proseccing";
                        }
                        if($sheet->getCell( 'B' . $row )->getValue() == "EN REPARTO"){
                            $data['status_livrison'] = "in delivery";
                        }
                        if($sheet->getCell( 'B' . $row )->getValue() == "MAL TRANSITADO" || $sheet->getCell( 'B' . $row )->getValue() == "REPARTO FALLIDO" || $sheet->getCell( 'B' . $row )->getValue() == "ALMACEN ESTACIONADO" || $sheet->getCell( 'B' . $row )->getValue() == "REEXPEDIDO" || $sheet->getCell( 'B' . $row )->getValue() == "ALM. REGULADOR" || $sheet->getCell( 'B' . $row )->getValue() == "DESTRUIDO" || $sheet->getCell( 'B' . $row )->getValue() == "ANULADO" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/ESTACIONADO" || $sheet->getCell( 'B' . $row )->getValue() == "PARALIZADO" || $sheet->getCell( 'B' . $row )->getValue() == "DEPOSITADO EN OFICINA" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/REPARTO FALLIDO" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/NO LOCALIZADO" || $sheet->getCell( 'B' . $row )->getValue() == "DISPONIBLE EN OFICINA" ){
                            $data['status_livrison'] = "incident";
                        }
                        if($sheet->getCell( 'B' . $row )->getValue() == "ENTREGADO" || $sheet->getCell( 'B' . $row )->getValue() == "ENTREGADO/PROVEEDOR" || $sheet->getCell( 'B' . $row )->getValue() == "DISPONIBLE EN PUNTO CONCERTADO"){
                            $data['status_livrison'] = "delivered";
                        }
                        if($sheet->getCell( 'B' . $row )->getValue() == "DEVUELTO" || $sheet->getCell( 'B' . $row )->getValue() == "DEVUELTO EN OFICINA" || $sheet->getCell( 'B' . $row )->getValue() == "PROVEEDOR/INFORMADA DEVOLUCION"){
                            $data['status_livrison'] = "canceled";
                        }
                        Lead::where('numEnvio',$sheet->getCell( 'A' . $row )->getValue())->update($data);
                }
            }
            return back();
        }catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->withErrors('There was a problem uploading the data!');
         }
    }

    public function changement(Request $request , $id)
    {
        $lead = Lead::where('id',$id)->first();

        $data = array();
        $nlead = "Ch-". $lead->n_lead;
        $data['n_lead'] = $nlead;
        $data['id_order'] = $lead->id_order;
        $data['id_user'] = $lead->id_user;
        $data['name'] = $lead->name;
        $data['phone'] = $lead->phone;
        $data['city'] = $lead->city;
        $data['address'] = $lead->address;
        $data['id_country'] = $lead->id_country;
        $data['id_city'] = $lead->id_city;
        $data['province'] = $lead->province;
        $data['zipcod'] = $lead->zipcod;
        $data['email'] = $lead->email;
        $data['id_product'] = $lead->id_product;
        $data['quantity'] = $lead->quantity;
        $data['lead_value'] = "0";
        $data['status_confirmation'] = $lead->status_confirmation;
        $data['last_status_change'] = $lead->last_status_change;
        try{
            Lead::insert($data);
        }catch(\Exception $e){
            return back()->withErrors('There was a problem the data!');
        }
        
        $leadid = Lead::where('n_lead',$nlead)->first();

        $data2 = array();
        $data2['id_lead'] = $leadid->id;
        $data2['id_product'] = $leadid->id_product;
        $data2['quantity'] = $leadid->quantity;
        $data2['lead_value'] = $leadid->lead_value;
        $data2['date_delivred'] = new DateTime();

        LeadProduct::insert($data2);

        return back();
    }

    public function inassigned()
    {
        $leads = Lead::where('status_confirmation','new order')->where('status',1)->get();

        foreach($leads as $v_lead){
            Lead::where('id',$v_lead->id)->update(['status' => 0]);
        }

        return back();
    }

    public function listconfirmed(Request $request)
    {
        $ids = $request->ids;
        //dd($ids);
        foreach($ids as $v_id){
            $lead = Lead::where('id',explode(",",$v_id))->where('status_confirmation','!=','confirmed')->first();
            $data = array();
            $data['status_confirmation'] = "confirmed";
            $data['date_confirmed'] = new DateTime();
            $data['date_delivred'] = new DateTime();
            $data['date_picking'] = new DateTime();
    
            Lead::where('id',$lead->id)->update($data);
            LeadProduct::where('id_lead',$lead->id)->update(['date_delivred' => new DateTime()]);
            $data2 = [
                'id_lead' => $lead->id,
                'id_user' => Auth::user()->id,
                'country_id' => Auth::user()->country_id,
                'status' => "confirmed",
                'date' => new DateTime(),
            ];
            historyStatu::insert($data2);
            $data3 = array();
            $data3['id_lead'] = $lead->id;
            $data3['id_user'] = Auth::user()->id;
            $data3['country_id'] = Auth::user()->country_id;
            $data3['status'] = "unpacked";
            $data3['comment'] = "unpacked";
            $data3['date'] = new DateTime();
            
            historyStatu::insert($data3);
        }//dd('yyyy');
        return response()->json(['success'=>true]);
    }

    public function changeMethodPayment($id)
    {

        $lead= Lead::where('id',$id)->first();
        $lead->method_payment = "PREPAID";
        $lead->ispaidapp = "1";
        $lead->save();
    }

    public function changeMethodPaymentToCOD($id)
    {
        
        $lead= Lead::where('id',$id)->first();
        $lead->method_payment = "COD";
        $lead->ispaidapp = "0";
        $lead->save();
    }



    public function client($id, Request $request)
    {
        
        $products = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();    
        $cities = Citie::where('id_country', Auth::user()->country_id)->get();
        $sellers = User::where('id_role',2)->get();
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $city = $request->city;
        $product = $request->id_prod;
        $confirmation = $request->confirmation;

        $lead = Lead::where('type','seller')->where('id',$id)->first();

        $leads = Lead::where('type','seller')
        ->with('product','leadpro','country','cities','livreur','seller')
        ->where('id_country', Auth::user()->country_id)->where('phone',$lead->phone);
        if($request->items){
            $items = $request->items;
        }else{
            $items = 10;
        }
        if($request->id_seller){
            $leads = $leads->where('id_user',$request->id_seller);
        }
        if(!empty($customer)){
            $leads = $leads->where('name',$customer);
        }
        if(!empty($ref)){
            $leads = $leads->where('n_lead',$ref);
        }
        if(!empty($city)){
            $leads = $leads->where('id_city',$city);
        }
        if(!empty($product)){
            $leads = $leads->where('id_product',$product);
        }
        if(!empty($confirmation)){
            $leads = $leads->whereIn('status_confirmation',$confirmation);
        }
        if(!empty($request->date)){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            $leads = $leads->whereBetween('created_at', [$date_from , $date_two]);
        }
        $leads= $leads->where('deleted_at',0)->paginate($items);

        return view('backend.leads.client', compact('products','cities','leads','lead','items','sellers'));
    }

    public function blackList(Request $request)
    {
        $checklead = Lead::where('type','seller')->where('id',$request->id)->where('status_livrison','unpacked')->first();
        if($checklead){
            $leads = Lead::where('phone',$checklead->phone)
                            ->where('status_livrison','returned')             
                            ->where('id_country',Auth::user()->country_id)
                            ->count();
            $leadsD =  Lead::where('phone',$checklead->phone)
                            ->where('status_livrison','delivered')             
                            ->where('id_country',Auth::user()->country_id)
                            ->count();
            $blackList = BlackList::where('phone',$checklead->phone)
                    ->where('id_country',Auth::user()->country_id)
                    ->count();

            $name = Lead::where('phone',$checklead->phone)->where('id_country',Auth::user()->country_id)->first()->name;
            // if($leads >= 2){
            //     if($blackList == 0){
                    $data = [
                        'name' => $name,
                        'id_user' => Auth::user()->id,
                        'phone' => $checklead->phone,
                        'id_country' => Auth::user()->country_id,
                    ];
            
                    BlackList::create($data);          
                    $lead = Lead::where('type','seller')
                            ->where('id',$request->id)
                            ->where('status_livrison','unpacked')->first();           
                                   
                    $data = [
                        'status_confirmation' => "black listed",
                        'status_livrison' => "unpacked",
                        'last_contact' => new DateTime(),
                        'last_status_change' => new DateTime(),
                        'status' => '0',
                        'id_assigned' => Auth::user()->id,
                        'date_delivred' => Null,
                    ];                                
                   Lead::where('type','seller')->where('id',$request->id)->where('status_livrison','unpacked')->update($data);
                    $data2 = [
                        'id_lead' => $request->id,
                        'id_user' => Auth::user()->id,
                        'country_id' => Auth::user()->country_id,
                        'status' => "black listed",
                        'comment' => "black listed",
                        'date' => new DateTime(),
                    ];
                    HistoryStatu::insert($data2);
                    return response()->json(['success'=>true]);
                // }else{
                //     $lead = Lead::where('type','seller')
                //             ->where('id',$request->id)
                //             ->where('status_livrison','unpacked')->first();           
                //     $data = [                      
                //         'status_confirmation' => "black listed",
                //        'status_livrison' => "unpacked",
                //        'last_contact' => new DateTime(),
                //         'last_status_change' => new DateTime(),
                //         'status' => '0',
                //         'id_assigned' => Auth::user()->id,
                //         'date_delivred' => Null,
                //     ];                                           
                //     Lead::where('type','seller')->where('id',$request->id)->where('status_livrison','unpacked')->update($data);
                //     $data2 = [
                //         'id_lead' => $request->id,
                //         'id_user' => Auth::user()->id,
                //         'status' => "black listed",
                //         'comment' => "black listed",
                //         'date' => new DateTime(),
                //     ];
                //     HistoryStatu::insert($data2);
                //     return response()->json(['success'=>true]);
                // }
            // }else{
            //     return response()->json(['error'=>false]);
            // }    
        }else{
            return response()->json(['error'=>false]);
        }
        
    }

    public function statusctest(Request $request)
    {
        $checklead = Lead::where('type','seller')->where('id',$request->id)->where('status_livrison','unpacked')->first();
        if($checklead){
            $sta = Lead::where('type','seller')->where('id',$request->id)->where('status_livrison','unpacked')->first();//dd($sta->status_confirmation);

            if($sta->status_confirmation == "no answer"){
                $date = date('Y-m-d H:i');
                $datemod = date('Y-m-d H:i', strtotime('+180 minutes', strtotime($date)));
                $data2 = array();
                $data2['status_confirmation'] = 'no answer 2';
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 2",
                    'comment' => "no answer 2",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);
            }elseif($sta->status_confirmation == "no answer 2"){
                $date = date('Y-m-d H:i');
                $datemod = date('Y-m-d H:i', strtotime('+180 minutes', strtotime($date)));
                $data2 = array();
                $data2['status_confirmation'] = "no answer 3";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 3",
                    'comment' => "no answer 3",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);
            }elseif($sta->status_confirmation == "no answer 3"){
                $time = "09:00:00";
                $tomorrow = Carbon::tomorrow()->format('Y-m-d');
                $datemod = $tomorrow .' '. $time;
                $data2 = array();
                $data2['status_confirmation'] = "no answer 4";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 4",
                    'comment' => "no answer 4",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);
            }elseif($sta->status_confirmation == "no answer 4"){
                $date = date('Y-m-d H:i');
                $datemod = date('Y-m-d H:i', strtotime('+180 minutes', strtotime($date)));
                $data2 = array();
                $data2['status_confirmation'] = "no answer 5";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 5",
                    'comment' => "no answer 5",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);

            }elseif($sta->status_confirmation == "no answer 5"){
                $date = date('Y-m-d H:i');
                $datemod = date('Y-m-d H:i', strtotime('+180 minutes', strtotime($date)));
                $data2 = array();
                $data2['status_confirmation'] = "no answer 6";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 6",
                    'comment' => "no answer 6",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);

            }elseif($sta->status_confirmation == "no answer 6"){
                $time = "09:00:00";
                $tomorrow = Carbon::tomorrow()->format('Y-m-d');
                $datemod = $tomorrow .' '. $time;
                $data2 = array();
                $data2['status_confirmation'] = "no answer 7";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 7",
                    'comment' => "no answer 7",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);

            }elseif($sta->status_confirmation == "no answer 7"){
                $date = date('Y-m-d H:i');
                $datemod = date('Y-m-d H:i', strtotime('+180 minutes', strtotime($date)));
                $data2 = array();
                $data2['status_confirmation'] = "no answer 8";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 8",
                    'comment' => "no answer 8",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);

            }elseif($sta->status_confirmation == "no answer 8"){
                $time = "09:00:00";
                $tomorrow = Carbon::tomorrow()->format('Y-m-d');
                $datemod = $tomorrow .' '. $time;
                $data2 = array();
                $data2['status_confirmation'] = "no answer 9";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer 9",
                    'comment' => "no answer 9",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);
            }elseif($sta->status_confirmation == "no answer 9"){
                $time = "09:00:00";
                $tomorrow = Carbon::tomorrow()->format('Y-m-d');
                $datemod = $tomorrow .' '. $time;
                $data2 = array();
                $data2['status_confirmation'] = "canceled by system";
                $data2['date_call'] = $datemod;
                $data2['last_status_change'] = new DateTime();
                $data2['last_contact'] = new DateTime();
            
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $datta = array();
                $datta['date_delivred'] = Null;
                LeadProduct::where('id_lead',$request->id)->update($datta);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "canceled by system",
                    'comment' => "canceled by system",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);
            }else{
                $date = date('Y-m-d H:i');
                $datemod = date('Y-m-d H:i', strtotime('+180 minutes', strtotime($date)));
                $data2 = [
                    "status_confirmation" => "no answer",
                    'last_status_change' => new DateTime(),
                    'date_call' => $datemod,
                    'last_contact' => new DateTime(),
                ];
                Lead::where('type','seller')->where('id',$request->id)->update($data2);
                $status = Lead::where('type','seller')->where('id',$request->id)->first();
                $data = [
                    'id_lead' => $status->id,
                    'id_user' => Auth::user()->id,
                    'country_id' => Auth::user()->country_id,
                    'status' => "no answer",
                    'comment' => "no answer",
                    'date' => new DateTime(),
                ];
        
                HistoryStatu::insert($data);
                return response()->json(['success'=>true]);
            }
        }else{
            return response()->json(['error'=>false]);
        }
        
    }

    public function outofstocks(Request $request)
    {
        $checklead = Lead::where('type','seller')->where('id',$request->id)->where('status_livrison','unpacked')->first();
        if($checklead){
            $data = [
                'status_confirmation' => "outofstock",
                'status_livrison' => "unpacked",
                'last_contact' => new DateTime(),
                'note' => "out of stock",
                'last_status_change' => new DateTime(),
                'status' => '0',
                'id_assigned' => Auth::user()->id,
                'date_delivred' => Null,
            ];

            Lead::where('type','seller')->where('id',$request->id)->update($data);
            $data2 = [
                'id_lead' => $request->id,
                'id_user' => Auth::user()->id,
                'country_id' => Auth::user()->country_id,
                'status' => "outofstock",
                'comment' => "out of stock",
                'date' => new DateTime(),
            ];
            HistoryStatu::insert($data2);
            $datta = array();
            $datta['date_delivred'] = Null;
            $datta['livrison'] = "unpacked";
            $datta['outstock'] = "0";
            LeadProduct::where('id_lead',$request->id)->update($datta);
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['error'=>false]);
        }
        
    }

    public function exports(Request $request)
    {
        $ids = $request->ids;
        foreach($ids as $v_id){
            $data[] = Lead::where('type','seller')->whereIn('id',explode(",",$v_id))->where('deleted_at',0)->get();
        }
    }


    public function downloads(Request $request,$leads)
    {
        $leads = json_decode($leads);
        //dd($leads);
        $leads = new LeadExport([$leads]);
        return Excel::download($leads, 'Leads.xlsx');
    }

    public function parseImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:xlsx',
        ]);
        
        $the_file  = $request->file('csv_file');
        
        try{
           $spreadsheet = IOFactory::load($the_file->getRealPath());
           $sheet        = $spreadsheet->getActiveSheet();
           $row_limit    = $sheet->getHighestDataRow();
           $column_limit = $sheet->getHighestDataColumn();
           $row_range    = range( 2, $row_limit );
           $column_range = range( 'A', $column_limit );
           $startcount = 2;
           $date = date('2025-03-01');
           
            $cot = 0;
           foreach ( $row_range as $row ) {
            //remove space from phone
                $rowsPerDate = 100;
                if($cot == 100){
                    $cot = 0;
                    $date = date('Y-m-d', strtotime($date . " +1 day"));
                }
                $sku = trim($sheet->getCell( 'B' . $row )->getValue());
                $product = Product::where('sku',$sku)->first();
                if(!empty($product)){
                    $checkorderexist = Lead::where('id_order',$sheet->getCell( 'A' . $row )->getValue())
                                            ->where('phone',$sheet->getCell( 'J' . $row )->getValue())  
                                            ->where('id_user',$product->id_user)                                       
                                            ->whereDate('created_at', $date)
                                            ->where('id_country',Auth::user()->warehouse_id)
                                            ->where('deleted_at',0)->first();
                   
                    // if(!empty($checkorderexist)){
                        // if($checkorderexist->id_product == $product->id){
                        //     continue;
                        // }
                    // }
                    if(empty($checkorderexist)){
                        $user = User::where('id',$product->id_user)->first();
                        $ne = substr(strtoupper($user->name), 0 , 1);
                        $n = substr(strtoupper($user->name), -1);
                        $last = Lead::orderby('id','DESC')->first();
                        if(!isset($last->id)){
                            $kk = 1;
                        }else{
                            $kk = $last->id + 1;
                        }
                        $n_lead = $ne .''.$n.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT);
                        $data = array();
                        $data['id_order'] = $sheet->getCell( 'A' . $row )->getValue();
                        $data['n_lead'] = $n_lead;
                        $data['id_user'] = $user->id;
                        $data['id_country'] = $product->id_country;
                        $data['name'] = $sheet->getCell( 'E' . $row )->getValue();
                        $data['address'] = $sheet->getCell( 'F' . $row )->getValue();
                        $data['city'] = $sheet->getCell( 'G' . $row )->getValue();
                        $data['province'] = $sheet->getCell( 'H' . $row )->getValue();
                        $data['zipcod'] = trim($sheet->getCell( 'I' . $row )->getValue());
                        $data['phone'] = $sheet->getCell( 'J' . $row )->getValue();
                        $data['email'] = $sheet->getCell( 'L' . $row )->getValue();
                        $data['note'] = $sheet->getCell( 'M' . $row )->getValue();
                        $data['quantity'] = $sheet->getCell( 'C' . $row )->getValue();
                        $data['id_product'] = $product->id;
                        $data['market'] = 'YouCan';
                        
                        $leadvalue = $sheet->getCell( 'D' . $row )->getValue();
                        if(str_contains($leadvalue, ','))
                        {
                            $leadvalue = str_replace(',', '.', $sheet->getCell( 'D' . $row )->getValue());
                        }
                        if (preg_match('/\d+(\.\d+)?/', $leadvalue, $matches)) {
                            $leadvalue = $matches[0];
                        } 
                        $data['lead_value'] = $leadvalue;

                        $data['status_confirmation'] = $sheet->getCell( 'O' . $row )->getValue();
                        if($sheet->getCell( 'O' . $row )->getValue() == "confirmed"){
                           $data['status_livrison'] = $sheet->getCell( 'P' . $row )->getValue();
                           $data['status_payment'] = $sheet->getCell( 'Q' . $row )->getValue();//dd(date("Y-m-d", strtotime('+ 2' , strtotime($date))));
                           $data['date_confirmed'] = $date;
                           $data['date_picking'] = date('Y-m-d', strtotime($date . " +2 days"));
                           $data['date_delivred'] = date('Y-m-d', strtotime($date . " +4 days"));
                        }
                        $checkduplicated = Lead::where('phone',$sheet->getCell( 'J' . $row )->getValue())
                                        ->where('id_product',$product->id)
                                        ->whereDate('created_at',$date)
                                        ->where('deleted_at',0)->count();
                        if($checkduplicated != 0){
                            $data['status_confirmation'] = "duplicated"; 
                        }
                        if(Zipcode::where('name', $sheet->getCell( 'I' . $row )->getValue())->where('id_country',$product->id_country)->count() != 0){
                            $data['status_confirmation'] = "out of area"; 
                        }
                        if($product->id_country == "12"){
                            if(Zipcode::where('id_country',$product->id_country)->where('name', 'like','%'.substr($data['zipcod'] , 0 , 4).'%')->count() != 0){
                                $data['status_confirmation'] = "out of area";
                            }
                        }
                        // if(!empty(strtoupper($sheet->getCell( 'N' . $row )->getValue())) !=  "COD"){
                        //     $data['status_confirmation'] = "confirmed";
                        //     $data['last_contact'] = new DateTime();
                        //     $data['ispaidapp'] = "1";
                        //     $data['method_payment'] = "PREPAID";
                        //     $data['date_shipped'] = new DateTime();
                        //     $data['date_confirmed'] = new DateTime();
                        //     $data['date_picking'] = new DateTime();
                        // }
                        if(strtoupper($sheet->getCell( 'N' . $row )->getValue()) ==  "PREPAID"){
                            // $data['status_confirmation'] = "confirmed";                        
                            $data['ispaidapp'] = "1";
                            $data['method_payment'] = "PREPAID";
                        }
                        $data['created_at'] = $date;
                        Lead::insert($data);

                        $lastid = Lead::where('n_lead',$n_lead)->first();
                        $data2 = array();
                        $data2['id_lead'] = $lastid->id;
                        $data2['id_product'] = $lastid->id_product;
                        $data2['quantity'] = $lastid->quantity;
                        $data2['lead_value'] = $lastid->lead_value;
                        // if(!empty(strtoupper($sheet->getCell( 'N' . $row )->getValue())) != "COD"){
                        //     $data2['date_delivred'] = new DateTime();
                        // }
                        if(strtoupper($sheet->getCell( 'N' . $row )->getValue()) ==  "PREPAID"){
                            // $data2['date_delivred'] = new DateTime();
                        }

                        $history = array();
                        $history['id_lead'] = $lastid->id;
                        $history['status'] = "new order";
                        $history['created_at'] = $date;
                        HistoryStatu::insert($history);

                        $history2 = array();
                        $history2['id_lead'] = $lastid->id;
                        $history2['status'] = $lastid->status_confirmation;
                        $history2['created_at'] = $date;
                        HistoryStatu::insert($history2);
                        
                        if($lastid->status_confirmation == "confirmed"){
                           $history3 = array();
                           $history3['id_lead'] = $lastid->id;
                           $history3['status'] = $lastid->status_livrison;
                           $history3['created_at'] = $lastid->date_delivred;
                           HistoryStatu::insert($history3);
                        }
                        LeadProduct::insert($data2);
                    }else{
                        
                        $product = Product::where('sku',$sheet->getCell( 'B' . $row )->getValue())->first();
                        $data2 = array();
                        $data2['id_lead'] = $checkorderexist->id;
                        $data2['id_product'] = $product->id;
                        $data2['quantity'] = $sheet->getCell( 'C' . $row )->getValue();
                        $leadvalue = $sheet->getCell( 'D' . $row )->getValue();
                        if(str_contains($leadvalue, ','))
                        {
                            $leadvalue = str_replace(',', '.', $sheet->getCell( 'D' . $row )->getValue());
                        }
                        if (preg_match('/\d+(\.\d+)?/', $leadvalue, $matches)) {
                            $leadvalue = (float)$matches[0];
                        } 
                        $data2['lead_value'] = $leadvalue;
                        $checkorderexist->lead_value = $checkorderexist->lead_value + $leadvalue;
                        $checkorderexist->quantity = $checkorderexist->quantity + $sheet->getCell( 'C' . $row )->getValue();
                        $checkorderexist->save();
                        LeadProduct::insert($data2);

                    }
                }
                $cot ++;
                $startcount++;
            }
            $the_file  = $request->file('csv_file');

            $userName = auth()->user()->name;
    
            $filename = $userName . '_' . date('Y-m-d H:i'). '.' .$the_file->getClientOriginalExtension();
    
            $the_file->move(storage_path('app/uploads'), $filename);
            
        } catch (Exception $e) {
           $error_code = $e->errorInfo[1];
           return back()->withErrors('There was a problem uploading the data!');
        }
        return back();
    }
        

    public function processImport(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $date = New DateTime();
        //dd($csv_data);
        try{
            foreach ($csv_data as $row) {//dd($row);
                $lead = new Lead();
                $pro = new LeadProduct();
                foreach (config('app.db_fields') as $index => $field) {
                    $lead->$field = $row[$request->fields[$field]];
                }
                    $date = new DateTime();
                    $ne = substr(strtoupper(Auth::user()->name), 0 , 1);
                    $n = substr(strtoupper(Auth::user()->name), -1);
                    $city = 'EY';
                    $ct = substr(strtoupper($city), 0 , 1);
                    $c = substr(strtoupper($city), -1);
                    $year = substr(strtoupper(date('Y')), 2);
                    $month = date('m');
                    $day = date('d');
                    $last = Lead::orderby('id','DESC')->first();
                    if(!isset($last->id)){
                        $kk = 1;
                    }else{
                        $kk = $last->id + 1;
                    }
                    $lead->n_lead = $ne .''.$n.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT);
                    $lead->id_product = $request->product;
                    $prod = Product::where('id',$request->product)->first();
                    $lead->id_user = Auth::user()->id;
                    $lead->id_country = $prod->id_country;
                    $lead->created_at = $date;
                    if(Lead::where('id_product',$request->product)->where('name',$lead->name)->where('phone','like','%'.$lead->phone.'%')->whereDate('created_at',date('Y-m-d', strtotime($date)))->where('deleted_at',0)->count() != 0){
                        $lead->status_confirmation = "duplicated";
                    }
                    if(Zipcode::where('name', $lead->zipcod)->count() != 0){
                        $lead->status_confirmation = "out of area";
                    }
                    if(!empty($lead->name) && !empty($lead->lead_value) && !empty($request->product) && !empty($lead->phone)){
                        $lead->save();
                        $pro->id_lead = $lead->id;
                        $pro->id_product = $lead->id_product;
                        $pro->quantity = (float)$lead->quantity;
                        $pro->lead_value = (float)$lead->lead_value;
                        $pro->save();
                    }
                    
            }
        }catch(\Exception $e){
            redirect()->back();
        }
        

        return redirect()->route('leads.index')->with('success', 'Import finished.');
    }

    public function voice(Request $request)
    {
        if ($request->hasFile('voice')) {
            
            $path = $request->file('voice')->store('voices', 'public');

            return response()->json(['status' => 'success', 'path' => $path]);
        }

        return response()->json(['status' => 'error', 'message' => 'No file found'], 400);
    }
}
