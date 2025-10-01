<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DateTime;
use App\Models\{Lead,Product};
use App\Models\User;
use App\Models\Citie;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Countrie;
use App\Models\historystatu;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Carbon\Carbon;

class CallcenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */  
    public function index(Request $request) 
    {

            $agents_all = User::join('history_status', function($join)
            {$join->on('users.id', '=', 'history_status.id_user');}) 
            ->where('id_role',3)->where('users.country_id', Auth::user()->country_id)
            ->select('users.id','users.name')
            ->groupBy('users.id','users.name'); 
             $date = date('Y-m-d', strtotime("-1 days"));
             $date2 = date('Y-m-d');         
             $agents_details = clone $agents_all ;
             return view('backend.callcenter.index', compact('agents_details','agents_all','date','date2'));
       
    }
    public function filter(Request $request)
    {
        if(!$request->all()){
            return redirect()->route('callcenter.index');
        }else{
            $input = $request->all();
            $validator = Validator::make($input, [
                'date' => "required",
                'date2' => "required",
                'agent' => "required|nullable",
            ]); 
            if ($validator->fails()) {
            
                return redirect('callcenter.index')->withErrors($validator)->withInput();
            }
                $agents_all = User::join('history_status', function($join)
                {$join->on('users.id', '=', 'history_status.id_user');}) 
                ->where('id_role',3)->where('users.country_id', Auth::user()->country_id)
                ->select('users.id','users.name')
                ->groupBy('users.id','users.name'); 
                $agents_details = clone $agents_all ;  
                if($request->agent != 'all'){
                    $agents_details->where('users.id',$request->agent);
                } 
                $agent_id =$request->agent;    
                $date = $request->date  ;
                $date2 = $request->date2 ;   
                return view('backend.callcenter.index', compact('agents_details','agents_all','date','date2','agent_id'));

        }
    }
    public function filterx(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'date' => "required",
            'date2' => "required",
            'agent' => "required|nullable",
        ]); 
        if ($validator->fails()) {
            return redirect('callcenter.index')->withErrors($validator)->withInput();
        }
        $agents_all = User::CheckLeads()->where('id_role',3)->where('users.country_id', Auth::user()->country_id)->select('users.id','name',DB::raw('count(history_status.id_lead) as total_lead'));
        $agents_details = clone $agents_all ;
        if($request->agent != 'all'){
            $agents_details->where('users.id',$request->agent);
        }
        $agent_id =$request->agent;
        $date = $request->date;
        $date2 = $request->date2;
        return view('backend.callcenter.index', compact('agents_details','agents_all','date','date2','agent_id'));
    }
    public function costumer(Request $request,$type)
    {
        $role_id = 0;
        if($type == 'seller'){
                $products = Product::whereHas('users', function($q){
                $q->where('id_role','2');
            })->where('id_country', Auth::user()->country_id)->get();
            $role_id = 2;
        }else{
            $products = Product::whereHas('users', function($q){
                $q->where('id_role','10');
            })->where('id_country', Auth::user()->country_id)->get();
            $role_id = 11;
        }
            
            
                            
        $costumers = User::where('id_role', $role_id)->where('country_id', Auth::user()->country_id)->get();

        $total = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('deleted_at',0);

        $confirmed = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('deleted_at',0);

        $rejected = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','canceled')->where('deleted_at',0);

        $canceledbysysteme = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','canceled by system')->where('deleted_at',0);

        $new = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','new order')->where('deleted_at',0);

        $duplicated = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','duplicated')->where('deleted_at',0);

        $wrong = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','wrong')->where('deleted_at',0);

        $outofstock = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','outofstock')->where('deleted_at',0);

        $noanswer = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','like','%'.'no answer'.'%')->where('deleted_at',0);

        $call = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','call later')->where('deleted_at',0);

        $area = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','out of area')->where('deleted_at',0);

        $chartconfirmed = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed');

        $chartrejected = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','canceled');

        $chartcanceledbysestem = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','canceled by system');

        $chartnew = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','new order');

        $chartduplicated = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','duplicated');

        $chartwrong = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','wrong');

        $chartoutofstock = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','outofstock');

        $chartnoanswer = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','like','%'.'no answer'.'%');

        $chartcall = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','call later');

        $chartarea = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','out of area');
        
        $orders = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('deleted_at',0)->count();
        
        $unpacked = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','unpacked')->where('deleted_at',0)->count();
       
        $delivered = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','delivered')->where('deleted_at',0)->count();
        
        $shipped = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','shipped')->where('deleted_at',0)->count();
       
        $canceled = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','rejected')->where('deleted_at',0)->count();

        $returned = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','returned')->where('deleted_at',0)->count();

        $transit = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','in transit')->where('deleted_at',0)->count();

        $chartunpacked = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','unpacked');

        $chartincident = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','incident');

        $chartindelivery = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','in delivery');

        $chartpacked = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','item packed');

        $chartdelivered = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','delivered');

        $chartshipped = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','shipped');

        $chartcanceled = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','rejected');

        $chartreturned = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','returned');

        $charttransit = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','in transit');

        $chartpicking = Lead::where('type', $type)->where('id_country', Auth::user()->country_id)->where('status_confirmation','confirmed')->where('status_livrison','picking process');
        
        if($request->seller_name){
            $total = $total->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $total = $total->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $total = $total->whereDate('created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $total = $total->whereDate('leads.created_at','>=',$date_from)->whereDate('created_at','<=',$date_two);
            }
        }
        $total = $total->count();
        if($request->seller_name){
            $confirmed = $confirmed->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $confirmed = $confirmed->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $confirmed = $confirmed->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $confirmed = $confirmed->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $confirmed = $confirmed->count();
        if($request->seller_name){
            $rejected = $rejected->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $rejected = $rejected->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $rejected = $rejected->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $rejected = $rejected->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $rejected = $rejected->count();
        if($request->seller_name){
            $canceledbysysteme = $canceledbysysteme->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $canceledbysysteme = $canceledbysysteme->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $canceledbysysteme = $canceledbysysteme->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $canceledbysysteme = $canceledbysysteme->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $canceledbysysteme = $canceledbysysteme->count();
        if($request->seller_name){
            $new = $new->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $new = $new->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $new = $new->whereDate('created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $new = $new->whereDate('leads.created_at','>=',$date_from)->whereDate('created_at','<=',$date_two);
            }
        }
        $new = $new->count();
        if($request->seller_name){
            $duplicated = $duplicated->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $duplicated = $duplicated->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $duplicated = $duplicated->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $duplicated = $duplicated->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $duplicated = $duplicated->count();
        if($request->seller_name){
            $wrong = $wrong->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $wrong = $wrong->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $wrong = $wrong->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $wrong = $wrong->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $wrong = $wrong->count();
        if($request->seller_name){
            $outofstock = $outofstock->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $outofstock = $outofstock->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $outofstock = $outofstock->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $outofstock = $outofstock->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $outofstock = $outofstock->count();
        if($request->seller_name){
            $noanswer = $noanswer->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $noanswer = $noanswer->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $noanswer = $noanswer->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $noanswer = $noanswer->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $noanswer = $noanswer->count();
        if($request->seller_name){
            $call = $call->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $call = $call->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $call = $call->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $call = $call->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $call = $call->count();
        if($request->seller_name){
            $area = $area->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $area = $area->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $area = $area->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $area = $area->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $area = $area->count();

        //chart
        if($request->seller_name){
            $chartconfirmed = $chartconfirmed->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartconfirmed = $chartconfirmed->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartconfirmed = $chartconfirmed->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartconfirmed = $chartconfirmed->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartconfirmed = $chartconfirmed->where('deleted_at',0)->count();

        if($request->seller_name){
            $chartrejected = $chartrejected->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartrejected = $chartrejected->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartrejected = $chartrejected->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartrejected = $chartrejected->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartrejected = $chartrejected->where('deleted_at',0)->count();

        if($request->seller_name){
            $chartcanceledbysestem = $chartcanceledbysestem->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartcanceledbysestem = $chartcanceledbysestem->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartcanceledbysestem = $chartcanceledbysestem->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartcanceledbysestem = $chartcanceledbysestem->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartcanceledbysestem = $chartcanceledbysestem->where('deleted_at',0)->count();

        if($request->seller_name){
            $chartnew = $chartnew->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartnew = $chartnew->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartnew = $chartnew->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartnew = $chartnew->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartnew = $chartnew->where('deleted_at',0)->count();
        if($request->seller_name){
            $chartduplicated = $chartduplicated->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartduplicated = $chartduplicated->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartduplicated = $chartduplicated->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartduplicated = $chartduplicated->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartduplicated = $chartduplicated->where('deleted_at',0)->count();
        if($request->seller_name){
            $chartwrong = $chartwrong->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartwrong = $chartwrong->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartwrong = $chartwrong->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartwrong = $chartwrong->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartwrong = $chartwrong->where('deleted_at',0)->count();
        if($request->seller_name){
            $chartoutofstock = $chartoutofstock->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartoutofstock = $chartoutofstock->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartoutofstock = $chartoutofstock->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartoutofstock = $chartoutofstock->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartoutofstock = $chartoutofstock->where('deleted_at',0)->count();
        if($request->seller_name){
            $chartnoanswer = $chartnoanswer->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartnoanswer = $chartnoanswer->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartnoanswer = $chartnoanswer->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartnoanswer = $chartnoanswer->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartnoanswer = $chartnoanswer->where('deleted_at',0)->count();

        if($request->seller_name){
            $chartcall = $chartcall->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartcall = $chartcall->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartcall = $chartcall->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartcall = $chartcall->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartcall = $chartcall->where('deleted_at',0)->count();
        if($request->seller_name){
            $chartarea = $chartarea->where('id_user',$request->seller_name);
        }
        if($request->call_product){
            $chartarea = $chartarea->where('id_product',$request->call_product);
        }
        if($request->date_call){
            $parts = explode(' to ' , $request->date_call);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartarea = $chartarea->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartarea = $chartarea->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartarea = $chartarea->where('deleted_at',0)->count();

        //shipping
       
        //chart shipping
        if($request->seller){
            $chartunpacked = $chartunpacked->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartunpacked = $chartunpacked->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartunpacked = $chartunpacked->whereDate('date_confirmed', $date_from);
            }else{
                $date_two = $parts[1];
                $chartunpacked = $chartunpacked->whereBetween('date_confirmed', [$date_from , $date_two]);
            }
        }
        $chartunpacked = $chartunpacked->where('deleted_at',0)->count();


        if($request->seller){
            $chartdelivered = $chartdelivered->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartdelivered = $chartdelivered->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartdelivered = $chartdelivered->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartdelivered = $chartdelivered->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartdelivered = $chartdelivered->where('deleted_at',0)->count();

        if($request->seller){
            $chartpacked = $chartpacked->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartpacked = $chartpacked->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartpacked = $chartpacked->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartpacked = $chartpacked->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartpacked = $chartpacked->where('deleted_at',0)->count();
        if($request->seller){
            $chartshipped = $chartshipped->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartshipped = $chartshipped->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartshipped = $chartshipped->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartshipped = $chartshipped->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartshipped = $chartshipped->where('deleted_at',0)->count();
        if($request->seller){
            $chartcanceled = $chartcanceled->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartcanceled = $chartcanceled->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartcanceled = $chartcanceled->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartcanceled = $chartcanceled->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartcanceled = $chartcanceled->where('deleted_at',0)->count();
        if($request->seller){
            $chartreturned = $chartreturned->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartreturned = $chartreturned->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartreturned = $chartreturned->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartreturned = $chartreturned->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartreturned = $chartreturned->where('deleted_at',0)->count();
        if($request->seller){
            $charttransit = $charttransit->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $charttransit = $charttransit->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $charttransit = $charttransit->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $charttransit = $charttransit->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $charttransit = $charttransit->where('deleted_at',0)->count();

        if($request->seller){
            $chartpicking = $chartpicking->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartpicking = $chartpicking->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartpicking = $chartpicking->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartpicking = $chartpicking->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartpicking = $chartpicking->where('deleted_at',0)->count();
    
        if($request->seller){
            $chartincident = $chartincident->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartincident = $chartincident->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartincident = $chartincident->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartincident = $chartincident->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartincident = $chartincident->where('deleted_at',0)->count();
        if($request->seller){
            $chartindelivery = $chartindelivery->where('id_user',$request->seller_name);
        }
        if($request->shipped_product){
            $chartindelivery = $chartindelivery->where('id_product',$request->shipped_product);
        }
        if($request->date_shipped){
            $parts = explode(' to ' , $request->date_shipped);
            $date_from = $parts[0];
            if(count($parts) == 1){
                $chartindelivery = $chartindelivery->whereDate('leads.created_at', $date_from);
            }else{
                $date_two = $parts[1];
                $chartindelivery = $chartindelivery->whereDate('leads.created_at','>=',$date_from)->whereDate('leads.created_at','<=',$date_two);
            }
        }
        $chartindelivery = $chartindelivery->where('deleted_at',0)->count();

        // $quantity_stock = Stock::join('products','products.id','stocks.id_product')
        //                             ->with('products')
        //                             ->where('id_user',Auth::user()->id)
        //                             ->where('id_warehouse', Auth::user()->country_id)
        //                             ->orderby('stocks.created_at','desc')->get();

        // $low_stock_product = Product::join('stocks','stocks.id_product','products.id')
        //                             ->where('id_country', Auth::user()->country_id)
        //                             ->where('id_user', Auth::user()->id)
        //                             ->select(DB::raw('products.name, products.image , products.low_stock, SUM(stocks.qunatity) AS quantity'))
        //                             ->groupBy('name','image','low_stock')->get();

        // $import_product = Product::join('stocks','stocks.id_product','products.id')
        //                 ->where('id_user', Auth::user()->id)
        //                 ->where('id_country', Auth::user()->country_id)
        //                 ->limit(5)
        //                 ->select(DB::raw('products.name, products.image, SUM(stocks.qunatity) AS quantity '))->groupBy('name','image')->get();

        return view('backend.callcenter.costumer', compact('products','total','costumers','confirmed','rejected','canceledbysysteme','new','duplicated','wrong','outofstock','noanswer','call','area',  'chartconfirmed','chartrejected','chartcanceledbysestem','chartnew','chartduplicated','chartwrong','chartoutofstock','chartnoanswer','chartcall','chartarea','orders','unpacked','delivered','shipped','canceled','returned','transit','chartunpacked','chartdelivered','chartpacked','chartshipped','chartcanceled','chartreturned','charttransit','chartpicking','chartincident','chartindelivery'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function details(Request $request, $id)
    {
    //    try { 
        $url = explode('&' , $id); 
        $id_assigned = $url[0];
        $sellers = User::where('id_role',2)->get();
        $products = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $productss = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $product = Stock::with('products')->where('id_warehouse', Auth::user()->country_id)->get();
        $cities = Citie::where('id_country', Auth::user()->country_id)->get();
        $countries = Countrie::where('id', Auth::user()->country_id)->get();
        $customer = $request->customer;
        $ref = $request->ref;
        $phone = $request->phone1;
        $phone2 = $request->phone2;
        $conf = $request->confirmation;
        $leads = Lead::with('product','country','cities','leadproduct')->where('leads.deleted_at',0)->where('id_country', Auth::user()->country_id)->where('id_assigned', $id_assigned)->orderBy('id', 'DESC');
    
        if(!empty($customer)){
            $leads = $leads->where('name',$customer);
        }
        if($request->seller){
            $leads = $leads->where('id_user',$request->seller);
        }
        if(!empty($ref)){
            $leads = $leads->where('n_lead',$ref);
        }
        if(!empty($phone)){
            $leads = $leads->where('phone',$phone);
        }
        if(!empty($phone2)){
            $leads = $leads->where('phone2',$phone2);
        }
        if(!empty($phone2)){
            $leads = $leads->where('phone2',$phone2);
        }
        if(!empty($conf)){
            $leads = $leads->where('status_confirmation',$conf);
        }
        if(!empty($request->livraison)){
            $leads = $leads->where('status_livrison',$request->livraison);
        }
        if(!empty($store)){
            $leads = $leads->whereIn('id_product',explode(",",$productstore[0]['id']));
        }
        if($request->agent){
            $leads = $leads->where('id_assigned',$request->agent);
        }
        if($request->date){
            // dd($request->date);
            $parts = explode(' - ' , $request->date);
            //dd($parts);
            $date_from = $parts[0];
            $date_two = $parts[1];
            if($date_from == $date_two){
                $leads = $leads->whereDate('last_contact', $date_from );
            }else{
                $leads = $leads->whereBetween('last_contact', [$date_from , $date_two]);
            }
        }
        if(isset($id)){
            $url = explode('&' , $id);
            $id = $url[0];
            $date_from = $url[1];
            $date_two = $url[2];
          
            if($date_from == $date_two){
              
                $leads = $leads->whereDate('last_contact', $date_from );
            }else{
             
                $leads = $leads->whereBetween('last_contact', [$date_from , $date_two]);
            }
         }
         
        $items = $request->items ?? 10; 
        $leads= $leads->get();
      
        $agents = User::where('country_id', Auth::user()->country_id)->where('users.id',$id_assigned);
        $confirmatriste = $agents->first();
         $query = Lead::where('id_assigned',$id_assigned) ; 
        $query_source  = $query->whereBetween('last_status_change',[$date_from." 00:00:00" , $date_two." 23:59:59"]);      
        $delivered = clone $query_source; 
        $delivered =  $delivered->where('status_confirmation', 'LIKE', '%confirmed%')->where('status_livrison', 'LIKE', '%delivered%')
        ->count(); 
        if(!$confirmatriste){
            return redirect()->route('callcenter.index');
        }

        return view('backend.callcenter.details', compact('agents','delivered','id_assigned','products','productss','cities','countries','leads','items','sellers','date_from','date_two','confirmatriste')); 
   
//     } catch (\Throwable $th) {
//         return redirect('callcenter');
//    }
}
}
