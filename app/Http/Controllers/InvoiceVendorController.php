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

class InvoiceVendorController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['leadinvoice' => function ($query) {
            $query->with(['Lead' => function ($query) {
                $query->with(['leadproduct', 'leadbyvendor']);
            }]);
        }])->whereHas('user', function ($query) {
            $query->where('id_role', '10');
        })->where('id_warehouse', Auth::user()->country_id);

        if ($request->search) {
            $invoices = $invoices->where('ref', 'like', '%' . $request->search . '%')->orwhere('amount', 'like', '%' . $request->search . '%')->orwhere('status', 'like', '%' . $request->search . '%');
        }
        if ($request->ref) {
            $invoices = $invoices->where('ref', 'like', '%' . $request->ref . '%');
        }
        if ($request->customer) {
            $invoices = $invoices->where('id_user', $request->customer);
        }
        if ($request->payment) {
            $invoices = $invoices->where('status', $request->payment);
        }
        $invoices = $invoices->orderby('id', 'desc')->get();
        //dd($invoices);
        return view('backend.invoices.vendor.index', compact('invoices'));
    }

    public function print(Request $request, $id)
    {
        $invoice = Invoice::where('id', $id)->first();
        if ($invoice) {

            $user = User::where('id', $invoice->id_user)->first();
            $sellerpara = SellerParameter::where('id_seller', $user->id)->orderby('id', 'desc')->first();
            $colierfact = LeadInvoice::with(['Lead' => function ($query) {
                $query->with('leadproduct');
            }])->where('id_invoice', $invoice->id)->get();
            $parameter = Parameter::where('id_country', Auth::user()->country_id)->first();
            $products = LeadInvoice::join('lead_products', 'lead_products.id_lead', '=', 'lead_invoices.id_lead')
            ->join('products', 'products.id', '=', 'lead_products.id_product')
            ->where('id_invoice', $id)
            ->select('products.name AS product_name', 'products.price_vente AS price', 'lead_products.quantity AS quantity')
            ->groupBy('products.name', 'products.price_vente', 'lead_products.quantity')
            ->get();
            return view('backend.invoices.vendor.print', compact('invoice', 'user', 'sellerpara', 'colierfact', 'parameter','products'));
        }

        return redirect()->route('invoices-vendor.index');
    }
    public function downloadInvoices(Request $request)
    {
        $zip = new ZipArchive;

        $zipFileName = 'invoicesvendors.zip';

        $filesToZip = array();

        $ids = $request->ids;
       
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) {   
          
            foreach($ids as $id){
               
                $invoice = Invoice::where('id',$id)->first();

                if($invoice){
                    
                    $user = User::where('id', $invoice->id_user)->first();
                    $sellerpara = SellerParameter::where('id_seller', $user->id)->orderby('id', 'desc')->first();
                    $colierfact = LeadInvoice::with(['Lead' => function ($query) {
                        $query->with('leadproduct');
                    }])->where('id_invoice', $invoice->id)->get();
                    $parameter = Parameter::where('id_country', Auth::user()->country_id)->first();
                    $products = LeadInvoice::join('lead_products', 'lead_products.id_lead', '=', 'lead_invoices.id_lead')
                                ->join('products', 'products.id', '=', 'lead_products.id_product')
                                ->where('id_invoice', $id)
                                ->select('products.name AS product_name', 'products.price_vente AS price', 'lead_products.quantity AS quantity')
                                ->groupBy('products.name', 'products.price_vente', 'lead_products.quantity')
                                ->get();
                    if(empty($invoice->pdf)) {
                        
                        $invoice->pdf = $invoice->ref.'.pdf';
                        $invoice->save();
                    }
                    $pdf = PDF::loadView('backend.invoices.vendor.pdf', compact('invoice','user','sellerpara','colierfact','parameter','products'));

                    $pdf->save(public_path('invoices/').$invoice->pdf );
    
                    array_push($filesToZip,  public_path('invoices/').$invoice->pdf);
              
                   
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
    public function paied(Request $request)
    {
        $id = $request->ids;
        foreach ($id as $v_id) {
            $data = [
                'status' => 'paid',
                'date_payment' => new DateTime(),
            ];
            Invoice::whereIn('id', explode(",", $v_id))->update($data);
            $leads = LeadInvoice::where('id_invoice', explode(",", $v_id))->get();
            foreach ($leads as $v_lead) {
                $data2 = [
                    'status_payment' => 'paid',
                ];
                Lead::where('id', $v_lead->id_lead)->update($data2);
            }
        }
        return response()->json(['success' => true]);
    }

    public function export(Request $request)
    {
        $id = $request->ids;
        foreach ($id as $v_id) {
            $data[] = LeadInvoice::whereIn('id_invoice', explode(",", $v_id))->get();
        }
    }

    public function download(Request $request, $allids)
    {
        $allids = json_decode($allids);
        $id = $allids;
        $id = new InvoicesExport([$id]);
        //dd($id);
        return Excel::download($id, 'Invoices.xlsx');
    }

    public function update($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        if ($invoice->status != "paid") {
            $countrie = CountrieFee::where('id_user', $invoice->id_user)->where('id_country', $invoice->id_warehouse)->first();
            $user = User::where('id', $invoice->id_user)->first();
            $colierfact = LeadInvoice::with(['Lead' => function ($query) {
                $query->with('leadproduct');
            }])->where('id_invoice', $invoice->id)->get();
            //dd($colierfact);
            $imports = ImportInvoice::with(['import' => function ($query) {
                $query = $query->with('product');
            }])->where('id_invoice', $invoice->id)->get();

            return view('backend.invoices.orders', compact('invoice', 'user', 'colierfact', 'countrie', 'imports'));
        } else {
            return redirect()->back();
        }
    }

    public function lead($id)
    {
        $invo = LeadInvoice::where('id', $id)->first();
        $lead = Lead::where('id', $invo->id_lead)->first();
        $countrie = CountrieFee::where('id_user', $lead->id_user)->where('id_country', Auth::user()->country_id)->first();

        $invoice = Invoice::where('id', $invo->id_invoice)->first();

        $fees = (($lead->lead_value * $countrie->percentage) / 100);

        Invoice::where('id', $invoice->id)->update(['amount' => $invoice->amount - $lead->lead_value + $fees]);

        LeadInvoice::where('id', $id)->delete();

        Lead::where('id', $lead->id)->update(['status_payment' => 'paid service']);

        return redirect()->back();
    }

    public function import($id)
    {
        $importinv = ImportInvoice::where('id', $id)->first();
        $import = Import::where('id', $importinv->id_import)->first();

        Import::where('id', $import->id)->update(['status_payment' => 'not paid']);
        $invoice = Invoice::where('id', $importinv->id_invoice)->first();
        Invoice::where('id', $importinv->id_invoice)->update(['amount' => $invoice->amount +  $import->price]);

        ImportInvoice::where('id', $id)->delete();

        return redirect()->back();
    }

    public function paid($id)
    {
        $data = [
            'status' => 'paid',
            'date_payment' => new DateTime(),
        ];
        Invoice::whereIn('id', $id)->update($data);
        $leads = LeadInvoice::where('id_invoice', $id)->get();
        foreach ($leads as $v_lead) {
            $data2 = [
                'status_payment' => 'paid',
            ];
            Lead::where('id', $v_lead->id_lead)->update($data2);
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $leadinvoice = LeadInvoice::where('id_invoice', $invoice->id)->get();
        foreach ($leadinvoice as $v_lead) {
            Lead::where('id', $v_lead->id_lead)->update(['status_payment' => 'paid service']);
            LeadInvoice::where('id_lead', $v_lead->id_lead)->delete();
        }
        $imports = ImportInvoice::where('id_invoice', $invoice->id)->get();
        foreach ($imports as $v_import) {
            Import::where('id', $v_import->id_import)->update(['status_payment' => 'not paid']);
            ImportInvoice::where('id_import', $v_import->id_import)->delete();
        }
        EntredLeadInvoice::where('id_invoice', $invoice->id)->delete();
        Invoice::where('id', $id)->delete();

        return redirect()->back();
    }

    public function affiliate_invoices()
    {
    }
}
