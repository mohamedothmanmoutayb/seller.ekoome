<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Sheet;
use App\Models\Client;
use App\Models\Import;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Countrie;
use App\Models\Document;
use Google\Service\Sheets;
use App\Models\LeadInvoice;
use App\Models\LeadProduct;
use App\Models\CountrieFee;
use App\Models\LastInvoice;
use App\Models\IslandZipcode;
use App\Models\MenorIslande;
use App\Models\HistoryStatu;
use App\Models\ImportInvoice;
use App\Models\SellerParameter;
use App\Models\EntredLeadInvoice;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Auth;
use DateTime;
use App\Notifications\UserActivated;
use App\Notifications\UserInactive;
use App\Notifications\InvoiceGenerated;
use App\Notifications\ManagerAssigned;
class CustomerController extends Controller
{
    public function index(Request $request)
    {

        $clients = Client::where('name', Null)->where('phone1', Null)->where('city', Null)->get();
        foreach($clients as $v_client){
            Client::where('id',$v_client->id)->delete();
        }
        $notfactu = Lead::with('leadinvoi')->where('status_confirmation','confirmed')->where('status_livrison','delivered')->where('status_payment','In progress')->orderby('id','desc')->get();
        // foreach($notfactu as $v_lead){
        //     if(empty($v_lead['leadinvoi'])){
        //         //dd($v_lead->id);
        //         //Lead::where('id',$v_lead->id)->update(['status_confirmation' => 'confirmed','status_livrison'=>'delivered','status_payment'=>'paid service']);
        //     }
        // }
        $agents = User::where('id_role',6)->get();
        $managers = User::where('id_role',8)->get();
        if(Auth::user()->id_role == 1){
            $customers = User::with(['leadss' => function($query){
                $query = $query->where('id_country',Auth::user()->country_id);
            },'manager','fees' => function($query){
                $query = $query->with('countr');
            }])->where('id_role','2');
        }else{
            $customers = User::join('history_countries','history_countries.id_user','users.id')->with(['lead','manager','fees' => function($query){
                $query = $query->with('countr');
            }])->where('id_role','2')->where('country_id', Auth::user()->country_id)->where('id_manager',Auth::user()->id);
        }
        if(!empty($request->search)){
            $customers = $customers->where('name','like','%'.$request->search.'%')->orwhere('telephone','like','%'.$request->search.'%')->orwhere('email','like','%'.$request->search.'%');
        }//dd($customers->limit(2)->get());
        $customers= $customers->where('id_role','2')->paginate('10');
        return view('backend.customers.index', compact('customers','agents','managers'));
    }

    public function store(Request $request)
    {
        $check = User::where('email',$request->email)->count();
        if($check == 0){
            $check = User::where('departement',$request->departement)->count();
            if($check == 0){
                $data = array();
                $data['id_manager'] = $request->manager;
                $data['departement'] = $request->departement;
                $data['name'] = $request->name;
                $data['telephone'] = $request->phone;
                $data['email'] = $request->email;
                $data['country_id'] = Auth::user()->country_id;
                $data['id_role'] = "2";
                $data['is_active'] = '1';
                $data['password'] = Hash::make($request->password);
                User::insert($data);
                $user = User::where('name',$request->name)->where('email',$request->email)->orderby('id','desc')->first();
                $id = $user->id;
                if($request->manager){
                    $user =  User::where('id',$request->manager)->first();
                    $usera->notify(new ManagerAssigned($user->email));
                }
                return response()->json(['success'=>true , 'id' => $id]);
            }else{
                return response()->json(['departement'=>false]);
            }
        }else{
            return response()->json(['email'=>false]);
        }
        
    }

    public function active($id)
    {
        $data = [
            'is_active' => '1'
        ];
        User::where('id',$id)->update($data);
        $user=User::findOrfail($id);
        $user->notify(new UserActivated());
        return redirect()->back();
    }

    public function inactive($id)
    {
        $data = [
            'is_active' => '0'
        ];
        User::where('id',$id)->update($data);
        $user=User::findOrfail($id);
        $user->notify(new UserInactive());
        return redirect()->back();
    }

    public function situation(Request $request)
    {
        $leads = Lead::join('lead_products','lead_products.id_lead','leads.id')->where('status_confirmation','confirmed')->whereIn('status_livrison',['delivered','returned'])->where('leads.id_country', Auth::user()->country_id)->whereIn('status_payment',['paid service','prepaid','return'])->select('leads.lead_value AS Value', 'leads.n_lead AS Lead' , 'leads.name AS name' , 'leads.status_livrison AS livrison' , 'leads.status_payment AS payment' ,'leads.id AS Id')->groupby('leads.created_at','leads.n_lead','leads.name', 'leads.status_livrison' ,'leads.status_payment','leads.id');
        if($request->items)
        {
            $items = $request->items;
        }else{
            $items = 100;
        }
        $leads = $leads->paginate($items);
            $invoice = Invoice::where('id_warehouse',Auth::user()->country_id)->orderby('id','desc')->first();
        
        if(!empty($invoice->id)){
            $ref = $invoice->ref + 1;
        }else{
            $ref = 1;
        }
        
        //$lead = Lead::join('lead_products','lead_products.id_lead','leads.id')->where('status_confirmation','confirmed')->where('status_payment','paid service')->where('id_user',$id)->get();
        //dd($lead);
        return view('backend.customers.details', compact('leads','items','ref'));
    }

    public function paiedall(Request $request)
    {
        $ids = $request->ids;
        foreach($ids as $v_id){
            $leads = Lead::where('id_user',explode(",",$v_id))->whereIn('status_payment',['paid service','prepaid'])->get();
            //dd($leads);
            foreach($leads as $v_lead){
                $data = [
                    'status_payment' => 'In progress',
                ];
                Lead::where('id',$v_lead->id)->update($data);
                $data2 = [
                    'id_lead' => $v_lead->id,
                    'id_user' => Auth::user()->id,
                    'status' => 'payement Prossing',
                    'comment' => 'payement Prossing',
                    'date' => new DateTime(),
                ];
                HistoryStatu::insert($data2);
            }
        }
        return response()->json(['success'=>true]);
    }

    public function paied(Request $request)
    {
        $ids = $request->ids;
        $countrie = Countrie::where('id',Auth::user()->country_id)->first();
        $deef = 0;
        $codfess = 0;
        $delivered = 0;
        $return = 0;
        $sumreturn = 0;
        $fulfillement = 0;
        $confirmationfees = 0;
        $delivredfees = 0;
        $orderdelivered = 0;
        $amountorder = 0;
        $island_shipping = 0;
        $island_count_shipping = 0;
        $island_return = 0;
        $island_count_return = 0;
        $returmang = 0;
        $upsell = 0;
        $upsellcount = 0;
        $seller = CountrieFee::where('id_country',Auth::user()->country_id)->first();
        foreach($ids as $v_id){
            $data = [
                'status_payment' => 'paid',
            ];
            $id = Lead::where('id',$v_id)->where('id_country',Auth::user()->country_id)->first();
            $pro = Product::where('id_country',Auth::user()->country_id)->get();
            $sumimport = 0 ;
            foreach($pro as $v_pro){
                $idimport[] = Import::where('id_product',$v_pro->id)->where('id_country',Auth::user()->country_id)->where('status','confirmed')->where('status_payment','not paid')->get()->toarray();
                $sumimport = $sumimport + Import::where('id_product',$v_pro->id)->where('id_country',Auth::user()->country_id)->where('status','confirmed')->where('status_payment','not paid')->sum('price');
                Import::where('id_product',$v_pro->id)->where('status','confirmed')->where('status_payment','not paid')->update($data);
            }
            Lead::whereIn('id',explode(",",$v_id))->update($data);
            $poi = 0;
            $listpro = LeadProduct::whereIn('id_lead',explode(",",$v_id))->get();
            foreach($listpro as $v_pro){
                $weight = Product::where('id',$v_pro->id_product)->first();
                $poi = $poi + $weight->weight * $v_pro->quantity;
                if($v_pro->isupselle_seller == "1"){
                    $upsell = $upsell + $seller->upsell;
                    $upsellcount = $upsellcount + 1;
                }
            }
            $checkislan = IslandZipcode::where('zipcode',$id->zipcod)->count();
            if($checkislan != 0){
                if($id->status_livrison == "returned"){
                    $shipping = $seller->island_return;
                    $shipping = $seller->delivered_shipping + $seller->island_shipping;
                    $island_return = $island_return + $seller->island_return;
                    $sumreturn = $sumreturn + $seller->island_return;
                    $island_count_shipping = $island_count_shipping + 1;
                    $island_shipping = $island_shipping + $seller->island_shipping;
                    $island_count_return = $island_count_return + 1;
                }
            }else{
                if($id->status_livrison == "returned"){
                    $shipping = $seller->returned_shipping;
                    $sumreturn = $sumreturn + $seller->returned_shipping;
                }
                $shipping = $seller->delivered_shipping;
            }
            if($id->status_livrison == "delivered"){
                $delivered = $delivered + 1;
                $led = Lead::whereIn('id',explode(",",$v_id))->first();
                if($led->ispaidapp == 1){
                    $sum = 0;
                }else{
                    $sum = Lead::whereIn('id',explode(",",$v_id))->sum('lead_value');
                }
                $amountorder = $amountorder + $sum;
                $delivredfees = $delivredfees + $seller->delivered_fees;
                $returmang = $returmang;
            }else{
                $return = $return + 1;
                $delivredfees = $delivredfees;
                $returmang = $returmang + $seller->return_management;
                $sum = 0;
            }
            if($poi > 1){
                $first = ($poi - 1)/1;
                if(is_float($first)){
                    $correct = intval($first) + 1;
                }else{
                    $correct = $first;
                }
                $finalpoi = ($correct * 0.5) + $shipping;
            }else{
                $finalpoi = $shipping;
            }
            if($seller->vat != 0){
                $finalpoi = ((($finalpoi * $seller->vat ) / 100));
            }
            $orderdelivered = $orderdelivered + $finalpoi;
            $checkcodfess = ((($sum * $seller->percentage) / 100) );
            if($checkcodfess <= "0.9"){
                if($seller->vat != 0){
                    $checkcodfess = ((("0.9" * $seller->vat ) / 100));
                }else{
                    $checkcodfess = "0.9";
                }
            }else{
                if($seller->vat != 0){
                    $checkcodfess = ((($checkcodfess * $seller->vat ) / 100));
                }else{
                    $checkcodfess = $checkcodfess;
                }
            }
            if($id->status_livrison == "delivered"){
                $codfess = $codfess + $checkcodfess;
            }else{
                $codfess = $codfess;
                $checkcodfess = 0;
            }
            
            $fulfillement = $fulfillement + $seller->fullfilment;
            if($id->ispaidapp == "1"){
                $confirmationfees = $confirmationfees + 0;
                $confirmationfee = 0;
            }else{
                $confirmationfees = $confirmationfees + $seller->fees_confirmation;
                $confirmationfee = $seller->fees_confirmation;
            }
            $deef = $deef + ($sum - $confirmationfee - $seller->fullfilment - $finalpoi - $checkcodfess - $sumimport - $delivredfees) ;
        }
        if(empty($return)){
            $return = 0;
            $sumreturn = 0;
        }
        //dd($deef);
        $ref = Invoice::orderby('id','desc')->first();
        if(empty($ref->id)){
            $lastref = 1;
        }else{
            $lastref = $ref->ref + 1;
        }
        if(!empty($request->date)){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_two == $date_from){
                $countentred = Lead::where('id_country', Auth::user()->country_id)->whereDate('created_at',$date_from)->where('deleted_at','0')->count();
            }else{
                $countentred = Lead::where('id_country', Auth::user()->country_id)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=' , $date_two)->where('deleted_at','0')->count();
            }
        }
        $entred = $countentred * $seller->entred_fees;
        $negative = Invoice::where('id_warehouse',Auth::user()->country_id)->where('amount','<',0)->where('status','processing')->get();
        $sumnegative = Invoice::where('id_warehouse',Auth::user()->country_id)->where('amount','<',0)->where('status','processing')->sum('amount');
        $data2 = [
            'ref' => $request->ref,
            'reference_fiscale' =>  $request->ref,
            'id_warehouse' => Auth::user()->country_id,
            'id_user' => $id->id_user,
            'id_agent' => Auth::user()->id,
            'total_entred' => $countentred,
            'lead_entred' => $entred,
            'confirmation_fees' => $confirmationfees,
            'shipping_fees' => $delivredfees,
            'total_delivered' => $delivered,
            'order_delivered' => $orderdelivered,
            'total_return' => $return,
            'fullfilment' => $fulfillement,
            'order_return' => $sumreturn,
            'lead_upsell' => $upsell,
            'codfess' => $codfess,
            'island_return' => $island_return,
            'island_return_count' => $island_count_return,
            'island_shipping' => $island_shipping,
            'island_shipping_count' => $island_count_shipping,
            'amount_order' => $amountorder,
            'amount_last_invoice' => $sumnegative,
            'amount' => (($amountorder  - ($entred + $confirmationfees + $delivredfees + $orderdelivered + $fulfillement + $sumreturn + $upsell + $codfess + $island_return + $island_shipping + $request->storage + $returmang) + ($sumnegative))),
            'management_return' => $returmang,
            'storage' => $request->storage,
            'status' => "processing",
            'transaction' => $request->date,
        ];
        Invoice::insert($data2);
        $lastinvo = Invoice::where('ref',$request->ref)->first();

        if(!empty($request->date)){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_two == $date_from){
                $getcountentred = Lead::whereDate('created_at',$date_from)->get();
            }else{
                $getcountentred = Lead::whereBetween('created_at',[$date_from , $date_two])->get();
            }
            foreach($getcountentred as $v_entred){
                $dataentred = array();
                $dataentred['id_lead'] = $v_entred->id;
                $dataentred['id_invoice'] = $lastinvo->id;
                EntredLeadInvoice::insert($dataentred);
            }
        }
        foreach($ids as $v_id){
            $data3 = [
                'id_invoice' => $lastinvo->id,
                'id_lead' => $v_id,
            ];
            LeadInvoice::insert($data3);
        }
        foreach($negative as $v_inv){
            Invoice::where('id',$v_inv->id)->update(['status' => 'paid']);
            LastInvoice::insert(['id_warehouse' => $lastinvo->id_warehouse , 'id_invoice' => $lastinvo->id , 'id_invoice_negative' => $v_inv->id , 'amount' => $v_inv->amount ]);
        }
        foreach($idimport as $v_import){
            foreach($v_import as $v_imp){
                $data4 = [
                    'id_invoice' => $lastinvo->id,
                    'id_import' => $v_imp['id'],
                ];
                ImportInvoice::insert($data4);
            }
        }

        //download
        $invoice = Invoice::where('id',$lastinvo->id)->first();
        $countrie = CountrieFee::where('id_user',$invoice->id_user)->where('id_country',$invoice->id_warehouse)->first();
        $user = User::where('id',$invoice->id_user)->first();
        $user->notify(new InvoiceGenerated());
        $colierfact = LeadInvoice::with(['Lead' => function($query){
                $query->with('leadproduct');
        }])->where('id_invoice',$invoice->id)->get();
        //dd($colierfact);
        $imports = ImportInvoice::with(['import' => function($query){
            $query = $query->with('product');
        }])->where('id_invoice',$invoice->id)->get();
        // $pdf = Pdf::loadView('backend.invoices.print', $invoice, $countrie, $user, $colierfact, $imports);
        // return $pdf->download('invoice.pdf');
        return response()->json(['success'=>true]);
    
    }

    public function paides(Request $request)
    {
        $ids = $request->ids;
        $countrie = Countrie::where('id',Auth::user()->country_id)->first();
        $deef = 0;
        $codfess = 0;
        $delivered = 0;
        $return = 0;
        $sumreturn = 0;
        $fulfillement = 0;
        $confirmationfees = 0;
        $delivredfees = 0;
        $orderdelivered = 0;
        $amountorder = 0;
        $island_shipping = 0;
        $island_count_shipping = 0;
        $island_return = 0;
        $island_count_return = 0;
        $menor_island = 0;
        $menor_island_count_shipping = 0;
        $menor_island_return = 0;
        $menor_island_count_return = 0;
        $returmang = 0;
        $upsell = 0;
        $upsellcount = 0;
        $seller = CountrieFee::where('id_country',Auth::user()->country_id)->first();
        foreach($ids as $v_id){
            $lead = Lead::where('id',$v_id)->where('id_country',Auth::user()->country_id)->first();
            $poi = 0;
            $listpro = LeadProduct::whereIn('id_lead',explode(",",$v_id))->get();
            foreach($listpro as $v_pro){
                $weight = Product::where('id',$v_pro->id_product)->first();
                $poi = $poi + $weight->weight * $v_pro->quantity;
                if($v_pro->isupselle_seller == "1"){
                    $upsell = $upsell + $seller->upsell;
                    $upsellcount = $upsellcount + 1;
                }
            }
            $checkislan = IslandZipcode::where('zipcode',$id->zipcod)->count();
            if($checkislan != 0){
                if($id->status_livrison == "returned"){
                    $shipping = $seller->island_return;
                    $shipping = $seller->delivered_shipping + $seller->island_shipping;
                    $island_return = $island_return + $seller->island_return;
                    $sumreturn = $sumreturn + $seller->island_return;
                    $island_count_shipping = $island_count_shipping + 1;
                    $island_shipping = $island_shipping + $seller->island_shipping;
                    $island_count_return = $island_count_return + 1;
                }
            }elseif(MenorIslande::where('zipcode',$v_order->zipcod)->count() != 0){
                if($id->status_livrison == "returned"){
                    $shipping = $seller->menor_return;
                    $shipping = $seller->delivered_shipping + $seller->shipping_menor_island;
                    $menor_island_return = $island_return + $seller->menor_return;
                    $sumreturn = $sumreturn + $seller->menor_return;
                    $menor_island_count_shipping = $island_count_shipping + 1;
                    $menor_island = $island_shipping + $seller->shipping_menor_island;
                    $menor_island_count_return = $island_count_return + 1;
                }
            }else{
                if($id->status_livrison == "returned"){
                    $shipping = $seller->returned_shipping;
                    $sumreturn = $sumreturn + $seller->returned_shipping;
                }
                $shipping = $seller->delivered_shipping;
            }
            if($id->status_livrison == "delivered"){
                $delivered = $delivered + 1;
                $led = Lead::whereIn('id',explode(",",$v_id))->first();
                if($led->ispaidapp == 1){
                    $sum = 0;
                }else{
                    $sum = Lead::whereIn('id',explode(",",$v_id))->sum('lead_value');
                }
                $amountorder = $amountorder + $sum;
                $delivredfees = $delivredfees + $seller->delivered_fees;
                $returmang = $returmang;
            }else{
                $return = $return + 1;
                $delivredfees = $delivredfees;
                $returmang = $returmang + $seller->return_management;
                $sum = 0;
            }
            if($poi > 1){
                $first = ($poi - 1)/1;
                if(is_float($first)){
                    $correct = intval($first) + 1;
                }else{
                    $correct = $first;
                }
                $finalpoi = ($correct * 0.5) + $shipping;
            }else{
                $finalpoi = $shipping;
            }
            if($seller->vat != 0){
                $finalpoi = ((($finalpoi * $seller->vat ) / 100));
            }
            $orderdelivered = $orderdelivered + $finalpoi;
            $checkcodfess = ((($sum * $seller->percentage) / 100) );
            if($checkcodfess <= "0.9"){
                if($seller->vat != 0){
                    $checkcodfess = ((("0.9" * $seller->vat ) / 100));
                }else{
                    $checkcodfess = "0.9";
                }
            }else{
                if($seller->vat != 0){
                    $checkcodfess = ((($checkcodfess * $seller->vat ) / 100));
                }else{
                    $checkcodfess = $checkcodfess;
                }
            }
            if($id->status_livrison == "delivered"){
                $codfess = $codfess + $checkcodfess;
            }else{
                $codfess = $codfess;
                $checkcodfess = 0;
            }
            
            $fulfillement = $fulfillement + $seller->fullfilment;
            if($id->ispaidapp == "1"){
                $confirmationfees = $confirmationfees + 0;
                $confirmationfee = 0;
            }else{
                $confirmationfees = $confirmationfees + $seller->fees_confirmation;
                $confirmationfee = $seller->fees_confirmation;
            }
            $deef = $deef + ($sum - $confirmationfee - $seller->fullfilment - $finalpoi - $checkcodfess - $sumimport - $delivredfees) ;
        }
        $shipping = 0;
        $orders = Lead::where('status_confirmation','confirmed')->wherein('status_livrison',['in transit','in delivery','incident','rejected'])->where('shipping_fees','0')->where('id_country',Auth::user()->country_id)->get();
        foreach($orders as $v_order){
            $checkislan = IslandZipcode::where('zipcode',$v_order->zipcod)->count();
            if($checkislan != 0){
                $shipping = $shipping + $seller->delivered_shipping + $seller->island_shipping;
                $island_count_shipping = $island_count_shipping + 1;
                $island_shipping = $island_shipping + $seller->island_shipping;
            }elseif(MenorIslande::where('zipcode',$v_order->zipcod)->count() != 0){
                $shipping = $shipping + $seller->delivered_shipping + $seller->shipping_menor_island;
                $menor_island_count = $menor_island_count + 1;
                $menor_island = $menor_island + $seller->shipping_menor_island;
            }else{
                $shipping = $seller->delivered_shipping;
            }
            //calcul fees fulfilement
            $fulfillement = $fulfillement + $seller->fullfilment;
            //calcul fees confirmation
            if($id->ispaidapp == "1"){
                $confirmationfees = $confirmationfees + 0;
                $confirmationfee = 0;
            }else{
                $confirmationfees = $confirmationfees + $seller->fees_confirmation;
                $confirmationfee = $seller->fees_confirmation;
            }
            //calcul poied order
            $poi = 0;
            $listpro = LeadProduct::whereIn('id_lead',explode(",",$v_id))->get();
            foreach($listpro as $v_pro){
                $weight = Product::where('id',$v_pro->id_product)->first();
                $poi = $poi + $weight->weight * $v_pro->quantity;
            }
            //check poied
            if($poi > 1){
                $first = ($poi - 1)/1;
                if(is_float($first)){
                    $correct = intval($first) + 1;
                }else{
                    $correct = $first;
                }
                $finalpoi = ($correct * 0.5) + $shipping;
            }else{
                $finalpoi = $shipping;
            }
            if($seller->vat != 0){
                $finalpoi = ((($finalpoi * $seller->vat ) / 100));
            }
            $orderdelivered = $orderdelivered + $finalpoi;
        }
        if(!empty($request->date)){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_two == $date_from){
                $countentred = Lead::where('id_country', Auth::user()->country_id)->whereDate('created_at',$date_from)->where('deleted_at','0')->count();
            }else{
                $countentred = Lead::where('id_country', Auth::user()->country_id)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=' , $date_two)->where('deleted_at','0')->count();
            }
        }
        $entred = $countentred * $seller->entred_fees;
        $pro = Product::where('id_country',Auth::user()->country_id)->get();
        $sumimport = 0 ;
        foreach($pro as $v_pro){
            $idimport[] = Import::where('id_product',$v_pro->id)->where('id_country',Auth::user()->country_id)->where('status','confirmed')->where('status_payment','not paid')->get()->toarray();
            $sumimport = $sumimport + Import::where('id_product',$v_pro->id)->where('id_country',Auth::user()->country_id)->where('status','confirmed')->where('status_payment','not paid')->sum('price');
            Import::where('id_product',$v_pro->id)->where('status','confirmed')->where('status_payment','not paid')->update(['status_payment' => 'paid']);
        }
        $negative = Invoice::where('id_warehouse',Auth::user()->country_id)->where('amount','<',0)->where('status','processing')->get();
        $sumnegative = Invoice::where('id_warehouse',Auth::user()->country_id)->where('amount','<',0)->where('status','processing')->sum('amount');
        $data2 = [
            'ref' => $request->ref,
            'reference_fiscale' =>  $request->ref,
            'id_warehouse' => Auth::user()->country_id,
            'id_user' => $id->id_user,
            'id_agent' => Auth::user()->id,
            'total_entred' => $countentred,
            'lead_entred' => $entred,
            'confirmation_fees' => $confirmationfees,
            'shipping_fees' => $delivredfees,
            'total_delivered' => $delivered,
            'order_delivered' => $orderdelivered,
            'total_return' => $return,
            'fullfilment' => $fulfillement,
            'order_return' => $sumreturn,
            'lead_upsell' => $upsell,
            'codfess' => $codfess,
            'island_return' => $island_return,
            'island_return_count' => $island_count_return,
            'island_shipping' => $island_shipping,
            'island_shipping_count' => $island_count_shipping,
            'amount_order' => $amountorder,
            'amount_last_invoice' => $sumnegative,
            'amount' => (($amountorder  - ($entred + $confirmationfees + $delivredfees + $orderdelivered + $fulfillement + $sumreturn + $upsell + $codfess + $island_return + $island_shipping + $request->storage + $returmang) + ($sumnegative))),
            'management_return' => $returmang,
            'storage' => $request->storage,
            'status' => "processing",
            'transaction' => $request->date,
        ];
        Invoice::insert($data2);
        $lastinvo = Invoice::where('id_warehouse',Auth::user()->country_id)->where('ref',$request->ref)->first();
    }

    public function detail($id)
    {
        $customer = User::where('id', $id)->first();
        return response()->json($customer);
    }

    public function fees($id)
    {
        $fees = CountrieFee::with('country')->where('id_user',$id)->paginate('10');
        foreach($fees as $v_fees){
            $countries = Countrie::where('id','!=',$v_fees->id_country)->get();
        }
        if(empty($countries)){
            $countries = Countrie::get();
        }
        
        return view('backend.customers.fees', compact('fees','countries','id'));
    }

    public function feesstore(Request $request)
    {
        $data = [
            'id_country' => $request->country,
            'id_user' => $request->user,
            'entred_fees' => $request->entred,
            'fees_confirmation' => $request->confirmation,
            'delivered_fees' => $request->shipping,
            'upsell' => $request->upsell,
            'delivered_shipping' => $request->shippingdelivered,
            'returned_shipping' => $request->shippingreturned,
            'island_shipping' => $request->shippingisland,
            'island_return' => $request->shippingreturnedisland,
            'shipping_menor_island' => $request->menorshipping ,
            'return_menor_island' => $request->menorshippingreturn,
            'extra_kilog' => $request->extrakilog,
            'fullfilment' => $request->fullfilment,
            'percentage' => $request->percentage,
            'cod_fixed' => $request->codfixed,
            'return_management' => $request->returnmangement,
            'vat' => $request->vat,
        ];

        CountrieFee::insert($data);
        return response()->json(['success'=>true]);
    }

    public function orders(Request $request,$id){
        $orders = Lead::where('id_user', $id)->where('type','seller')->where('status_livrison','delivered')->where('id_country', Auth::user()->country_id)->get();
        if(!empty($request->search)){
            $orders = $orders->where('n_lead','like','%'.$request->search.'%')->get();
        }
        //dd($orders);
        return view('backend.customers.orders', compact('orders','id'));
    }

    public function feesupdate($id)
    {
        $fees = CountrieFee::where('id', $id)->first();
        return response()->json($fees);
    }

    public function editfees(Request $request)
    {
        $data = [
            'entred_fees' => $request->entred,
            'delivered_fees' => $request->shipping,
            'fees_confirmation' => $request->confirmation,
            'upsell' => $request->upsell,
            'delivered_shipping' => $request->shippingdelivered,
            'island_shipping' => $request->shippingdeliveredisland,
            'returned_shipping' => $request->shippingreturned,
            'island_return' => $request->shippingreturnedisland,
            'shipping_menor_island' => $request->menorshipping,
            'return_menor_island' => $request->menorreturn,
            'fullfilment' => $request->fullfilment,
            'percentage' => $request->percentage,
            'cod_fixed' => $request->codfixed,
            'extra_kilog' => $request->extrakilog,
            'return_management' => $request->returnmangement,
            'vat' => $request->vat,
        ];
        CountrieFee::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    public function details(Request $request)
    {
        $data = array();
        if($request->manager){
            $data['id_manager'] = $request->manager;
            
            $user =  User::where('id',$request->manager)->first();
            $user->notify(new ManagerAssigned($user->email));
            
        }
        $data['departement'] = $request->departement;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['telephone'] = $request->phone;
        $data['bank'] = $request->bank;
        $data['rib'] = $request->rib;

        User::where('id',$request->id)->update($data);
        return response()->json(['success'=>true]);
    }

    public function document($id)
    {
        $documents = Document::where('id_user', $id)->get();

        return view('backend.documents.index', compact('documents','id'));
    }

    public function parameter($id)
    {
        $parameter = SellerParameter::where('id_seller',$id)->first();

        return view('backend.customers.parameters', compact('parameter','id'));
    }

    public function parametercreate(Request $request)
    {
        $data = array();
        // $data['id_seller'] = $request->seller;
        $data['company_name'] = $request->name;
        $data['vat_number'] = $request->vat;
        $data['email'] = $request->email;
        $data['telephone'] = $request->phone;
        $data['zipcod'] = $request->zipcod;
        $data['country'] = $request->country;
        $data['city'] = $request->city;
        $data['website'] = $request->website;
        $data['address'] = $request->address;

        SellerParameter::insert($data);

        return response()->json(['success'=>true]);
    }

    public function parameterupdate(Request $request)
    {
        $data = array();
        $data['company_name'] = $request->name;
        $data['vat_number'] = $request->vat;
        $data['email'] = $request->email;
        $data['telephone'] = $request->phone;
        $data['zipcod'] = $request->zipcod;
        $data['country'] = $request->country;
        $data['city'] = $request->city;
        $data['website'] = $request->website;
        $data['address'] = $request->address;

        SellerParameter::where('id',$request->id)->update($data);
        
        return response()->json(['success'=>true]);
    }

    public function check(Request $request)
    {
        $check = SellerParameter::where('id_seller',$request->user)->first();
        if(empty($check)){
            return response()->json(['status'=>false]);
        }else{
            return response()->json(['status'=>true]);
        }
    }
}
