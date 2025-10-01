<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Import;
use App\Models\Invoice;
use App\Models\Countrie;
use App\Models\Parameter;
use App\Models\CountrieFee;
use App\Models\LeadInvoice;
use App\Models\ImportInvoice;
use App\Exports\InvoicesExport;
use App\Models\SellerParameter;
use App\Models\EntredLeadInvoice;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LastInvoice;
use Auth;
use DateTime;
use PDF;
use ZipArchive;
use App\Notifications\InvoiceGenerated;
class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['leadinvoice' => function($query){
            $query->with(['Lead' => function($query){
                $query->with(['leadproduct','leadbyvendor']);
            }],'user','seller');
        }])->whereHas('user', function($query){
            $query->where('id_role','2');
        })->where('id_warehouse',Auth::user()->country_id);      
        if($request->search){
            $invoices = $invoices->where(function($query) use ($request){
                $query->whereHas('user', function($subquery) use ($request) {
                    $subquery->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhere('ref', 'like', '%' . $request->search . '%')
                ->orWhere('status', 'like', '%' . $request->search . '%');
            });
                                
        }
        if($request->ref){
            $invoices = $invoices->where('ref','like','%'.$request->ref.'%');
        }
        if($request->customer){
            $invoices = $invoices->where('id_user',$request->customer);
        }
        if($request->payment){
            $invoices = $invoices->where('status',$request->payment);
        }
        if(!empty($request->date)){
            $parts = explode(' to ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_two == $date_from){
                $invoices = $invoices->whereDate('created_at','=',$date_from);
            }else{
                $invoices = $invoices->whereBetween('created_at', [$date_from , $date_two]);
            }
        }
        if($request->items){
            $items = $request->items;
        }else{
            $items = 20;
        }
        $invoices = $invoices->orderby('id','desc')->paginate($items);
        $sellers = User::where('id_role','2')->get();
        return view('backend.invoices.index', compact('invoices','sellers','items'));
    }

    public function print(Request $request,$id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if($invoice){
                $countrie = CountrieFee::where('id_user', $invoice->id_user)->where('id_country',$invoice->id_warehouse)->first();
                $user = User::where('id',$invoice->id_user)->first();
                $sellerpara = SellerParameter::where('id_seller',$user->id)->orderby('id','desc')->first();
                $colierfact = LeadInvoice::with(['Lead' => function($query){
                        $query->with('leadproduct');
                }])->where('id_invoice',$invoice->id)->get();
                $imports = ImportInvoice::with(['import' => function($query){
                    $query = $query->with('product');
                }])->where('id_invoice',$invoice->id)->get();//dd($imports);
                $parameter = Parameter::where('id_country', Auth::user()->country_id)->first();
                $lastinvoices = LastInvoice::with('invoic')->where('id_invoice',$invoice->id)->get();
                return view('backend.invoices.print', compact('invoice','user','sellerpara','colierfact','countrie','imports','parameter','lastinvoices'));
        }

        return redirect()->route('invoices.index');

    }


    public function printfiscal(Request $request,$id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if($invoice){
            $countrie = CountrieFee::where('id_user', $invoice->id_user)->where('id_country',$invoice->id_warehouse)->first();
            $user = User::where('id',$invoice->id_user)->first();
            $sellerpara = SellerParameter::where('id_seller',$user->id)->orderby('id','desc')->first();
            $colierfact = LeadInvoice::with(['Lead' => function($query){
                        $query->with('leadproduct');
                }])->where('id_invoice',$invoice->id)->get();
            $imports = ImportInvoice::with(['import' => function($query){
                    $query = $query->with('product');
                }])->where('id_invoice',$invoice->id)->get();//dd($imports);
            $parameter = Parameter::where('id_country', Auth::user()->country_id)->first();
            return view('backend.invoices.print-fiscal', compact('invoice','user','sellerpara','colierfact','countrie','imports','parameter'));
        }

        return redirect()->route('invoices.index');

    }

    public function externel(){

        $user = User::where('id_role','1')->first();
        $sellerpara = SellerParameter::where('id_seller',$user->id)->orderby('id','desc')->first();
        $parameter = Parameter::where('id_country', Auth::user()->country_id)->first();
        $imports =Import::with('products')->whereHas('products', function ($query) use ($user) {
                                $query->where('id_user', $user->id);
                            })
                            ->where('status_payment', 'not paid')
                            ->where('status', 'confirmed')
                            ->get();
                  
        return view('backend.invoices.externel', compact('user','sellerpara','parameter','imports'));
    }

    public function paied(Request $request)
    {
        $id = $request->ids;
        foreach($id as $v_id){
            $data = [
                'status' => 'paid',
                'date_payment' => new DateTime(),
            ];
            Invoice::whereIn('id',explode(",",$v_id))->update($data);
            $leads = LeadInvoice::where('id_invoice',explode(",",$v_id))->get();
            foreach($leads as $v_lead){
                $data2 = [
                    'status_payment' => 'paid',
                ];
                Lead::where('id',$v_lead->id_lead)->update($data2);
            }
        }
        return response()->json(['success'=>true]);
    }
    public function downloadInvoices(Request $request)
    {
        $zip = new ZipArchive;

        $zipFileName = 'invoicessellers.zip';

        $filesToZip = array();

        $ids = $request->ids;
       
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) {   
          
            foreach($ids as $id){
                $invoice = Invoice::where('id',$id)->first();
                if($invoice){
                    $countrie = CountrieFee::where('id_user', $invoice->id_user)->where('id_country',$invoice->id_warehouse)->first();
                    $user = User::where('id',$invoice->id_user)->first();
                    $sellerpara = SellerParameter::where('id_seller',$user->id)->orderby('id','desc')->first();
                    $colierfact = LeadInvoice::with(['Lead' => function($query){
                            $query->with('leadproduct');
                    }])->where('id_invoice',$invoice->id)->get();
                    $imports = ImportInvoice::with(['import' => function($query){
                        $query = $query->with('product');
                    }])->where('id_invoice',$invoice->id)->get();//dd($imports);
                    $parameter = Parameter::where('id_country', Auth::user()->country_id)->first();
                    // if(empty($invoice->pdf)){
                    //     $invoice->pdf = $invoice->ref.'.pdf';
                    //     $invoice->save();
                    // }
                    $pdf = PDF::loadView('backend.invoices.pdf', compact('invoice','user','sellerpara','colierfact','countrie','imports','parameter'));

                    $pdf->save(public_path('invoices/').$invoice->ref.'.pdf' );
    
                    array_push($filesToZip,  public_path('invoices/').$invoice->ref.'.pdf');
              
                   
                }
            }
        } else {
            return  "Failed to create the zip file.";
        }
        foreach ($filesToZip as $file) {
            $zip->addFile($file, basename($file));
        }
        
        $zip->close();
        
        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }

    public function export(Request $request)
    {
        $id = $request->ids;
        foreach($id as $v_id){
            $data[] = LeadInvoice::whereIn('id_invoice',explode(",",$v_id))->get();
        }
    }

    public function download(Request $request,$allids)
    {
        $allids = json_decode($allids);
        $id = $allids;
        $id = new InvoicesExport([$id]);
        //dd($id);
        return Excel::download($id, 'Invoices.xlsx');
    }

    public function update($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if($invoice->status != "paid"){
            $countrie = CountrieFee::where('id_user',$invoice->id_user)->where('id_country',$invoice->id_warehouse)->first();
            $user = User::where('id',$invoice->id_user)->first();
            $colierfact = LeadInvoice::with(['Lead' => function($query){
                    $query->with('leadproduct');
            }])->where('id_invoice',$invoice->id)->get();
            //dd($colierfact);
            $imports = ImportInvoice::with(['import' => function($query){
                $query = $query->with('product');
            }])->where('id_invoice',$invoice->id)->get();

            return view('backend.invoices.orders', compact('invoice','user','colierfact','countrie','imports'));
        }else{
            return redirect()->back();
        }
        
    }

    public function lead($id)
    {
        $invo = LeadInvoice::where('id',$id)->first();
        $lead = Lead::where('id',$invo->id_lead)->first();
        $countrie = CountrieFee::where('id_user',$lead->id_user)->where('id_country',Auth::user()->country_id)->first();
        
        $invoice = Invoice::where('id',$invo->id_invoice)->first();

        $fees = (($lead->lead_value * $countrie->percentage ) / 100);

        Invoice::where('id',$invoice->id)->update(['amount' => $invoice->amount - $lead->lead_value + $fees]);

        LeadInvoice::where('id',$id)->delete();

        Lead::where('id',$lead->id)->update(['status_payment' => 'paid service']);

        return redirect()->back();
    }

    public function import($id)
    {
        $importinv = ImportInvoice::where('id',$id)->first();
        $import = Import::where('id',$importinv->id_import)->first();

        Import::where('id',$import->id)->update(['status_payment' => 'not paid']);
        $invoice = Invoice::where('id',$importinv->id_invoice)->first();
        Invoice::where('id',$importinv->id_invoice)->update(['amount' => $invoice->amount +  $import->price]);

        ImportInvoice::where('id',$id)->delete();

        return redirect()->back();
    }

    public function paid($id)
    {
            $data = [
                'status' => 'paid',
                'date_payment' => new DateTime(),
            ];
            Invoice::whereIn('id',$id)->update($data);
            $leads = LeadInvoice::where('id_invoice',$id)->get();
            foreach($leads as $v_lead){
                $data2 = [
                    'status_payment' => 'paid',
                ];
                Lead::where('id',$v_lead->id_lead)->update($data2);
            }
        return redirect()->back();
    }

    public function delete($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        $leadinvoice = LeadInvoice::where('id_invoice',$invoice->id)->get();
        foreach($leadinvoice as $v_lead){
            Lead::where('id',$v_lead->id_lead)->update(['status_payment' => 'paid service']);
            LeadInvoice::where('id_lead',$v_lead->id_lead)->delete();
        }
        $imports = ImportInvoice::where('id_invoice',$invoice->id)->get();
        foreach($imports as $v_import){
            Import::where('id',$v_import->id_import)->update(['status_payment'=>'not paid']);
            ImportInvoice::where('id_import',$v_import->id_import)->delete();
        }
        EntredLeadInvoice::where('id_invoice',$invoice->id)->delete();
        Invoice::where('id',$id)->delete();

        return redirect()->back();
    }

   
    public function updateref(Request $request)
    {
        $invoice = Invoice::where('id',$request->invoice_id)->first();
        if($invoice){
            Invoice::where('id',$invoice->id)->update(['reference_fiscale' => $request->reference]);
        }
        return back();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $ref = Invoice::orderby('id','desc')->first();
        if(empty($ref->id)){
            $lastref = 1;
        }else{
            $lastref = $ref->ref + 1;
        }
        //imports
        $ids = array();
        $ids = $request->ids;

        $prices = $request->price;
       
        $data2 = [
            'reference_fiscale' =>  $lastref,
            'ref' => $lastref,
            'id_warehouse' => Auth::user()->country_id,
            'id_user' => $request->user,
            'id_agent' => Auth::user()->id,
            'total_entred' => $request->total_entred,
            'lead_entred' => $request->lead_entred,
            'confirmation_fees' => $request->confirmation_fees,
            'shipping_fees' => $request->shipping_fees,
            'total_delivered' => $request->total_delivered,
            'order_delivered' => $request->order_delivered,
            'total_return' => $request->total_return,
            'fullfilment' => $request->fullfilment,
            'order_return' => $request->order_return,
            'lead_upsell' => $request->lead_upsell,
            'codfess' => $request->codfess,
            'island_return' => $request->island_return,
            'island_return_count' => $request->island_return_count,
            'island_shipping' => $request->island_shipping,
            'island_shipping_count' => $request->island_shipping_count,
            'amount_order' => $request->amount_order,
            'amount' => $request->amount,
            'management_return' => $request->management_return,
            'storage' => $request->storage,
            'status' => "processing",
            'transaction' => $request->date,
        ];

        $lastinvo = Invoice::create($data2);
        $user = User::findorfail($request->user);
        if($user){
            $user->notify(new InvoiceGenerated());
        }
        foreach($ids as $key => $id){      
            if(!$id) break;                 
            $import = Import::where('id',$id)->first();
            //check price if it's not the same
            if($import->price != $prices[$key]){
                $data3 = [
                    'price' => $prices[$key],
                    'status_payment'  => 'paid'
                ];
                Import::where('id',$id)->update($data3);
            }else{
                $data3 = [
                    'status_payment'  => 'paid'
                ];
                Import::where('id',$id)->update($data3);
            }

            $data4 = [
                'id_invoice' => $lastinvo->id,
                'id_import' => $id,
            ];
            ImportInvoice::insert($data4);
        
        }

      
        return response()->json(['status'=>true]);
    }

    public function inactive(Request $request,$id)
    {
        Invoice::where('id',$id)->update(['is_active' => '0']);

        return back();
    }

    public function active(Request $request,$id)
    {
        Invoice::where('id',$id)->update(['is_active' => '1']);

        return back();
    }
}
