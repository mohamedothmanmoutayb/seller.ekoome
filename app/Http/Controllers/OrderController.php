<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lead;
use App\Models\User;
use App\Models\Citie;
use App\Models\Stock;
use App\Models\Upsel;
use App\Models\Sheet;
use App\Models\Province;
use App\Models\Product;
use App\Models\Countrie;
use App\Exports\LeadsDate;
use Google\Service\Sheets;
use App\Models\Reclamation;
use App\Models\LeadProduct;
use App\Models\LeadInvoice;
use App\Models\HistoryStatu;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;
use App\Exports\LeadsExport;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\HeadingRowImport;
use App\Http\Services\GoogleSheetServices;
use App\Models\WhatsAppAccount;
use App\Models\WhatsappOffersTemplate;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use App\Events\NewNotification;
use Pusher\Pusher;
use Auth;
use DateTime;
use PDF;

class OrderController extends Controller
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
        $payment = $request->payment;
        $produ = $request->id_prod;
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $cities = Citie::where('id_country', Auth::user()->country_id)->get();
        $countries = Countrie::get();
        
        $leads = Lead::with('product','country','cities','seller')->where('id_user', Auth::user()->id)->where('status_confirmation','confirmed')->where('id_country',Auth::user()->country_id)->orderBy('id', 'DESC');
        
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
        if($request->city){
            $leads = $leads->where('id_city','like','%'.$request->city.'%');
        }
        if($request->shipping){
            $leads = $leads->where('status_livrison',$request->shipping);
        }
        if($request->market){
            $leads = $leads->where('market',$request->market);
        }
        if($request->shipping_company){
            $leads = $leads->where('id_last_mille',$request->shipping_company);
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
        // $count = $leads->where('id_country',Auth::user()->country_id)->where('deleted_at',0)->count();
        // $leads = $leads->where('id_country',Auth::user()->country_id)->where('deleted_at',0); 
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
        $lastmille = ShippingCompany::get();
        $products = Product::orderBy('name')->get();
        
        
        return view('backend.leads.order', compact('proo','cities','leads','countries','items','count','offerTemplates','whatsappAccounts','lastmille','allLead'))
            ->with('i', (request()->input('page', 1) - 1) * $items);
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
        $leads = Lead::with('leadproducts','leadbyvendor')->where('id_user', Auth::user()->id)->where('status_confirmation','confirmed')->where('status_livrison','new lead')->where('id_country', Auth::user()->country_id)->where('deleted_at',0)->get()->groupby('id_product');//dd($leads);
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
        $usr = Product::where('id',$request->id)->first();
        $date = new DateTime();
        $ne = substr(strtoupper(Auth::user()->name), 0 , 1);
        $n = substr(strtoupper(Auth::user()->name), -1);
        $city = 'CD';
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
        $n_lead = $ne .''.$n.'-'.str_pad($kk, 5 , '0', STR_PAD_LEFT);
        $data = [
            'n_lead' => $n_lead,
            'id_user' => $usr->id_user,
            'name' => $request->namecustomer,
            'phone' => $request->mobile,
            'phone2' => $request->mobile2,
            'lead_value' => $request->total,
            'id_product' => $request->id,
            'id_country' => $request->country,
            'id_assigned' => Auth::user()->id,
            'status' => '1',
            'id_city' => $request->cityid,
            'id_zone' => $request->zoneid,
            'address' => $request->address,
            'created_at' => new DateTime(),
        ];
        Lead::insert($data);
        return response()->json(['success'=>true]);
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
        $proo = Product::where('id_country', Auth::user()->country_id)->where('id_user', Auth::user()->id)->get();
        $products = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $productss = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $product = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $provinces = Province::where('id_country', Auth::user()->country_id)->select('name','id')->get();
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $city = $request->city;
        $product = $request->id_prod;
        $confirmation = $request->confirmation;
        if(Auth::user()->id_role != "3"){
            $leads = Lead::where('type','seller')->with('product','leadpro','country','cities','livreur')->where('id_user', Auth::user()->id)->where('id_country', Auth::user()->country_id)->orderBy('id', 'DESC');
        }else{
            $leads = Lead::where('type','seller')->with('product','leadpro','country','cities')->where('id_user', Auth::user()->id)->where('id_assigned',null);
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
        $lead = Lead::where('type','seller')->with('product','leadpro','country','cities')->where('id_user', Auth::user()->id)->where('id', $id)->limit(1)->first();
        //dd($lead);
        $lead = Lead::where('type','seller')->with('product','leadpro','country','cities')->where('id_user', Auth::user()->id)->where('id',$lead->id)->orderby('id','asc')->limit(1)->first();
        $detailpro = Product::where('id',$lead->id_product)->first();
        $listupsel = LeadProduct::with('product')->where('id_lead',$lead->id)->where('isupsell',1)->get();
                        
        $detailupsell = Upsel::where('id_product',$lead->id_product)->get();
        $ledproo = LeadProduct::where('isupsell',0)->where('id_lead',$lead->id)->first();
        if(!$ledproo){
            $detailpro = Product::findOrfail($lead->id_product);
        }else{
            $detailpro = Product::findOrfail($lead->id_product);
        }
        
        $productseller = Product::where('id_user', Auth::user()->id)->where('id_country', Auth::user()->country_id)->get();
        $leadproduct = LeadProduct::with('product')->where('isupsell',1)->where('id_lead',$lead->id)->get();
        $allproductlead = LeadProduct::with('product')->where('id_lead',$lead->id)->get();
        $seller = User::where('id',$lead->id_user)->first();

        return view('backend.leads.leadagent', compact('seller','proo','products','productss','provinces','leads','lead','detailpro','detailupsell','listupsel','leadproduct','allproductlead','productseller'));       
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
            'id_user' => Auth::user()->id,
            'status' => "confirmed",
            'comment' => $request->commentdeliv,
            'date' => new DateTime(),
        ];
        historyStatu::insert($data2);
        $data3 = array();
        $data3['id_lead'] = $request->id;
        $data3['id_user'] = Auth::user()->id;
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
            'status' => "canceled",
            'comment' => $request->commentdeliv,
            'date' => new DateTime(),
        ];
        historyStatu::insert($data2);
        return response()->json(['success'=>true]);
    }


    public function details($id)
    {
        $leadss = LeadProduct::with('product','leads')->where('id_lead',$id)->get();
        $products = LeadProduct::where('id_lead',$id)->get();
        //dd($leads);
        $leads = json_decode($leadss);
        return response()->json($leads);
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
    
    

    public function settings()
    {
        return view('backend.leads.settings');
    }
    public function history(Request $request)
    {
        $history = HistoryStatu::with('delivery')->where('id_lead',$request->id)->get();
        //dd($history);
        $output = "";
        foreach($history as $v_history){
        $output.=
        '<tr>
            <td>'; foreach($v_history['delivery'] as $v_delivery){
                $output.=''. $v_delivery->name .'';
            }
            $output.='.</td>
            <td>'. $v_history->creaetd_at .'</td>
            <td>'. $v_history->status .'</td>
            <td>'. $v_history->date .'</td>
            <td>'. $v_history->comment .'</td>
        </tr>';
        }
        return response($output);
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

    public function change(Request $request){
        $lead = Lead::where('id',$request->id)->first();
        $citi = Citie::where('id',$lead->id_city)->first();
        if($request->statu == "delivered"){
            $feesdelivered = $citi->fees_delivered;
        }else{
            $feesdelivered = 0;
        }
        
        Lead::where('id',$lead->id)->update(['status_livrison' => $request->statu , 'fees_livrison' => $feesdelivered]);

        $data = array();
        $data['id_lead'] = $lead->id;
        $data['status'] = $request->statu;
        $data['comment'] = $request->statu;
        HistoryStatu::insert($data);

        // $notification = Notification::create([
        //     'user_id' => $lead->id_user,
        //     'type' => 'success',
        //     'title' => 'Order received',
        //     'message' => 'Order Status Change successfully to '. $request->statu ,
        //     'is_read' => false,
        //     'payload' => 'Order Status Change successfully.',
        // ]);
        
        
        // if ($lead) {
        //     $this->triggerPusherNotification($lead->id_user, $notification);
        // }
        
        return response()->json(['success'=>true]);
    }

    private function triggerPusherNotification($userId, $notification)
    {

        Log::info("Triggering Pusher notification for user ID: $userId");

        
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = [
            'notification_id' => $notification->id,
            'title' => $notification->title,
            'message' => $notification->message,
            'type' => $notification->type,
            'is_read' => $notification->is_read,
            'time' => $notification->created_at,
        ];

        $pusher->trigger('user.' . $userId, 'Notification', $data);

    }
}
