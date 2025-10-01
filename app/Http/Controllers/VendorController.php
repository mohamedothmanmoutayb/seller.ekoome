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
use App\Models\HistoryStatu;
use App\Models\ImportInvoice;
use App\Models\SellerParameter;
use App\Models\EntredLeadInvoice;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\GoogleSheetServices;
use Carbon\Carbon;
use Auth;
use DateTime;

class VendorController extends Controller
{
    public function index(Request $request)
    {

        $clients = Client::where('name', Null)->where('phone1', Null)->where('city', Null)->get();
        foreach ($clients as $v_client) {
            Client::where('id', $v_client->id)->delete();
        }
        // $notfactu = Lead::with('leadinvoi')->where('status_confirmation','confirmed')->where('status_livrison','delivered')->where('status_payment','In progress')->orderby('id','desc')->get();
        // foreach($notfactu as $v_lead){
        //     if(empty($v_lead['leadinvoi'])){
        //         //dd($v_lead->id);
        //         //Lead::where('id',$v_lead->id)->update(['status_confirmation' => 'confirmed','status_livrison'=>'delivered','status_payment'=>'paid service']);
        //     }
        // }
        $agents = User::where('id_role', 6)->get();
        $managers = User::where('id_role', 8)->get();
        if (Auth::user()->id_role == 1) {
            $customers = User::with(['leadss' => function ($query) {
                $query = $query->where('id_country', Auth::user()->country_id);
            }, 'fees' => function ($query) {
                $query = $query->with('countr');
            }])->where('id_role', '10');
        } else {
            $customers = User::join('history_countries', 'history_countries.id_user', 'users.id')->with(['lead', 'fees' => function ($query) {
                $query = $query->with('countr');
            }])->where('id_role', '10')->where('country_id', Auth::user()->country_id)->where('id_manager', Auth::user()->id);
        }
        if (!empty($request->search)) {
            $customers = $customers->where('name', 'like', '%' . $request->search . '%')->orwhere('telephone', 'like', '%' . $request->search . '%')->orwhere('email', 'like', '%' . $request->search . '%');
        } //dd($customers->limit(2)->get());
        $customers = $customers->where('id_role', '10')->paginate('15');

        return view('backend.vendor.index', compact('customers', 'agents', 'managers'));
    }

    public function store(Request $request)
    {
        $check = User::where('email', $request->email)->count();
        if ($check == 0) {
            $check = User::where('departement', $request->departement)->count();
            if ($check == 0) {
                $data = array();
                $data['id_manager'] = $request->manager;
                $data['departement'] = $request->departement;
                $data['name'] = $request->name;
                $data['telephone'] = $request->phone;
                $data['email'] = $request->email;
                $data['country_id'] = Auth::user()->country_id;
                $data['id_role'] = "10";
                $data['is_active'] = '1';
                $data['password'] = Hash::make($request->password);
                User::insert($data);
                $user = User::where('name', $request->name)->where('email', $request->email)->orderby('id', 'desc')->first();
                $id = $user->id;
                return response()->json(['success' => true, 'id' => $id]);
            } else {
                return response()->json(['departement' => false]);
            }
        } else {
            return response()->json(['email' => false]);
        }
    }

    public function active($id)
    {
        $data = [
            'is_active' => '1'
        ];
        User::where('id', $id)->update($data);
        return redirect()->back();
    }

    public function inactive($id)
    {
        $data = [
            'is_active' => '0'
        ];
        User::where('id', $id)->update($data);
        return redirect()->back();
    }

    public function situation(Request $request, $id)
    {
        $leads = Lead::join('products', 'products.id','leads.id_product')
        ->join('lead_products', 'lead_products.id_lead', 'leads.id')
        ->where('products.id_user',$id)
        ->where('status_confirmation', 'confirmed')
        ->whereIn('status_livrison', ['delivered', 'returned'])
        ->whereIn('payment_vendor', ['unpaid'])
        ->where('leads.id_country', Auth::user()->country_id)
        ->select(\DB::raw('SUM(lead_products.lead_value) AS Value, leads.n_lead AS Lead , leads.name AS name , leads.payment_vendor AS payment ,leads.id AS Id'))
        ->groupby('leads.created_at', 'leads.n_lead', 'leads.name', 'leads.payment_vendor', 'leads.id');
        // $leads = Lead::join('lead_products', 'lead_products.id_lead', 'leads.id')
        //     ->where('status_confirmation', 'confirmed')
        //     ->whereIn('status_livrison', ['delivered', 'returned'])
        //     ->where('leads.id_country', Auth::user()->country_id)
        //     ->whereIn('payment_vendor', ['unpaid'])
        //     ->where('id_user', $id)
        //     ->where('type', 'vendor')
        //     ->select(\DB::raw('SUM(lead_products.lead_value) AS Value, leads.n_lead AS Lead , leads.name AS name , leads.status_payment AS payment ,leads.id AS Id'))->groupby('leads.created_at', 'leads.n_lead', 'leads.name', 'leads.status_payment', 'leads.id');
        // dd($leads);
        if ($request->items) {
            $items = $request->items;
        } else {
            $items = 100;
        }
        $leads = $leads->paginate($items);

        return view('backend.vendor.details', compact('leads', 'id', 'items'));
    }

    public function paiedall(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $v_id) {
            $leads = Lead::where('id_user', explode(",", $v_id))->whereIn('status_payment', ['paid service', 'prepaid'])->get();
            //dd($leads);
            foreach ($leads as $v_lead) {
                $data = [
                    'status_payment' => 'In progress',
                ];
                Lead::where('id', $v_lead->id)->update($data);
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
        return response()->json(['success' => true]);
    }



    public function paied(Request $request)
    {
        $ids = $request->ids;
        $sum = 0;
        $delivered = 0;
        foreach ($ids as $id) {
            $data = [
                'payment_vendor' => 'paid',
            ];
            $lead = Lead::where('id', $id)->where('id_country', Auth::user()->country_id)->first();
            if ($lead) {
                if ($lead->status_livrison == "delivered") {
                    $delivered = $delivered + 1;
                    $leadProducts = LeadProduct::where('id_lead', $lead->id)->where('id_product',$lead->id_product)->get();
                    if ($leadProducts) {
                        foreach ($leadProducts as $leadPro) {
                            $product = Product::where('id', $leadPro->id_product)->first();
                            if ($product) {
                                $sum = $sum + (intval($product->price_vente) * intval($leadPro->quantity));
                                
                            }
                        }
                        Lead::whereIn('id', explode(",", $id))->update($data);
                    }
                }
            }
        }
        
        $ref = Invoice::orderby('id', 'desc')->first();

        if (empty($ref->id)) {
            $lastref = 1;
        } else {
            $lastref = $ref->ref + 1;
        }

        $data2 = [
            'ref' => $lastref,
            'id_warehouse' => Auth::user()->country_id,
            'id_user' => $product->id_user,
            'id_agent' => Auth::user()->id,
            'total_entred' => 0,
            'lead_entred' => 0,
            'confirmation_fees' => 0,
            'total_delivered' => $delivered,
            'total_return' => 0,
            'order_delivered' => 0,
            'amount_order' => 0,
            'amount' => $sum,
            'status' => "processing",
        ];

        Invoice::insert($data2);
        $lastinvo = Invoice::where('ref', $lastref)->first();


        foreach ($ids as $v_id) {
            $data3 = [
                'id_invoice' => $lastinvo->id,
                'id_lead' => $v_id,
            ];
            LeadInvoice::insert($data3);
        }

        return response()->json(['success' => true]);
    }

    public function detail($id)
    {
        $customer = User::where('id', $id)->first();
        return response()->json($customer);
    }

    public function fees($id)
    {
        $fees = CountrieFee::with('country')->where('id_user', $id)->paginate('10');
        foreach ($fees as $v_fees) {
            $countries = Countrie::where('id', '!=', $v_fees->id_country)->get();
        }
        if (empty($countries)) {
            $countries = Countrie::get();
        }

        return view('backend.vendor.fees', compact('fees', 'countries', 'id'));
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
            'fullfilment' => $request->fullfilment,
            'percentage' => $request->percentage,
            'return_management' => $request->returnmangement,
            'vat' => $request->vat,
        ];

        CountrieFee::insert($data);
        return response()->json(['success' => true]);
    }

    public function orders(Request $request, $id)
    {
        $orders = Lead::where('id_user', $id)->where('status_livrison', 'delivered')->where('type', 'vendor')->where('id_country', Auth::user()->country_id)->get();

        return view('backend.vendor.orders', compact('orders', 'id'));
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
            'fullfilment' => $request->fullfilment,
            'percentage' => $request->percentage,
            'return_management' => $request->returnmangement,
            'vat' => $request->vat,
        ];
        CountrieFee::where('id', $request->id)->update($data);
        return response()->json(['success' => true]);
    }

    public function details(Request $request)
    {
        $data = array();
        $data['departement'] = $request->departement;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['telephone'] = $request->phone;
        $data['bank'] = $request->bank;
        $data['rib'] = $request->rib;

        User::where('id', $request->id)->update($data);
        return response()->json(['success' => true]);
    }

    public function document($id)
    {
        $documents = Document::where('id_user', $id)->get();

        return view('backend.documents.index', compact('documents', 'id'));
    }

    public function parameter($id)
    {
        $parameter = SellerParameter::where('id_seller', $id)->first();

        return view('backend.vendor.parameters', compact('parameter', 'id'));
    }

    public function parametercreate(Request $request)
    {
        $data = array();
        $data['id_seller'] = $request->seller;
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

        return response()->json(['success' => true]);
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

        SellerParameter::where('id', $request->id)->update($data);

        return response()->json(['success' => true]);
    }
}
