<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\LeadProduct;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Auth;

class PaymentController extends Controller
{
    //
    public function delivred(Request $request)
    {
        $delivred = User::with(['country' ,  'leadlivreur', 'History' => function($query){
            $query = $query->with('leadlivreur');
        }]);
        if($request->search){
            $delivred = $delivred->where('name','like','%'.$request->search.'%')->orwhere('email','like','%'.$request->search.'%')->orwhere('telephone','like','%'.$request->search.'%');
        }
        $delivred = $delivred->where('id_role','7')->where('country_id', Auth::user()->country_id)->paginate(30);
        if($request->date){
            $parts = explode(' - ' , $request->date);
            $dated = $parts[0];
            $datef = $parts[1];
        }else{
            $dated = date('Y-m-d');
            $datef = date('Y-m-d');
        }
        //dd($delivred);
        return view('backend.payments.delivred', compact('delivred','dated','datef'));
    }

    public function orders(Request $request,$id)
    {
        $users = User::where('id',$id)->first();
        $leads = Lead::join('lead_products','lead_products.id_lead','leads.id')
                            ->join('products','products.id','lead_products.id_product')
                            ->join('cities','cities.id','leads.id_city')
                            ->where('status_confirmation','confirmed')->where('livreur_id',$users->id);
        if($request->date){
            $parts = explode(' - ' , $request->date);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_two == $date_from){
                $leads = $leads->whereBetween('leads.date_shipped', [$date_from , $date_two]);
            }else{
                $leads = $leads->where('leads.date_shipped', $date_from);
            }
        }
        if($request->payment){
            $leads = $leads->where('status_payment',$request->payment);
        }
        if($request->phone1){
            $leads = $leads->where('leads.phone',$request->phone1);
        }
        if($request->customer){
            $leads = $leads->where('leads.name',$request->customer);
        }
        if($request->ref){
            $leads = $leads->where('leads.n_lead',$request->ref);
        }
        $leads = $leads->select(\DB::raw('SUM(lead_products.lead_value) AS Value'),'leads.n_lead AS Lead','leads.name AS name','cities.name AS city', 'leads.status_payment AS payment' , 'leads.id AS Id')->groupby('leads.created_at','leads.n_lead','leads.name','cities.name','leads.status_payment','leads.id')->get();
        //dd($leads);
        return view('backend.payments.orders', compact('leads','id'));
    }

    public function details(Request $request,$id)
    {
        $users = User::where('id',$id)->first();
        $leads = Lead::join('lead_products','lead_products.id_lead','leads.id')
        ->where('status_confirmation','confirmed')
        ->where('status_payment','no paid')
        ->where('livreur_id',$users->id)
        ->select(\DB::raw('SUM(lead_products.lead_value) AS Value'),'leads.n_lead AS Lead', 'leads.status_payment AS payment' , 'leads.id AS Id')->groupby('leads.created_at','leads.n_lead','leads.status_payment','leads.id')->get();
        //dd($leads);
        return view('backend.payments.details', compact('leads'));
    }

    public function paied(Request $request)
    {
        $ids = $request->ids;
        foreach($ids as $v_id){
            $data = [
                'status_payment' => 'paid service',
            ];
            Lead::whereIn('id',explode(",",$v_id))->update($data);
        }
        return response()->json(['success'=>true]);
    }

    public function trackingnumber(Request $request)
    {
        $the_file  = $request->file('csv_file');
           //dd($the_file);
           //$product = $request->id_product;
           //$country = $request->id_country;
            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 2, $row_limit );
                $column_range = range( 'B', $column_limit );
                $startcount = 2;
                $data = array();
                //dd($row_range);
                foreach ( $row_range as $row ) {
                    Lead::where('tracking', $sheet->getCell( 'A' . $row )->getValue())->where('status_payment','no paid')->update(['status_payment' => 'paid service']);
                }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }

            return back();
    }

    public function oldtrackingnumber(Request $request)
    {
        $the_file  = $request->file('csv_file');
           //dd($the_file);
           //$product = $request->id_product;
           //$country = $request->id_country;
            try{
                $spreadsheet = IOFactory::load($the_file->getRealPath());
                $sheet        = $spreadsheet->getActiveSheet();
                $row_limit    = $sheet->getHighestDataRow();
                $column_limit = $sheet->getHighestDataColumn();
                $row_range    = range( 2, $row_limit );
                $column_range = range( 'B', $column_limit );
                $startcount = 2;
                $data = array();
                //dd($row_range);
                foreach ( $row_range as $row ) {
                    $order = Lead::where('tracking', $sheet->getCell( 'A' . $row )->getValue())->where('address',Null)->where('phone',Null)->whereIn('status_payment',['no paid','paid service'])->first();
                    if(!empty($order->id)){
                        Lead::where('id', $order->id)->update(['status_payment' => 'paid']);
                    }
                }
            } catch (Exception $e) {
                $error_code = $e->errorInfo[1];
                return back()->withErrors('There was a problem uploading the data!');
            }

            return back();
    }

    public function paidwithout(Request $request)
    {
        $ids = $request->ids;
        foreach($ids as $v_id){
            $data = [
                'status_payment' => 'paid',
            ];
            Lead::whereIn('id',explode(",",$v_id))->update($data);
        }
        return response()->json(['success'=>true]);

    }
}
