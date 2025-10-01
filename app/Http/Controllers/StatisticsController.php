<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Permission;
use App\Models\AgentRole;
use App\Models\LeadProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class StatisticsController extends Controller
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
    
    public function index(Request $request, $type)
    {  
        if($type == 'seller'){ 

            $id_role = 2;
        }
        if($type == 'affiliate'){ 
            $id_role = 11;
        }
        else back();
        
        $users = User::where('id_role',$id_role)->where('country_id', Auth::user()->country_id);
        if($request->search){
            $users = $users->where('name','like','%'.$request->search.'%')->orwhere('email','like','%'.$request->search.'%');
        }
        $users = $users->get();//dd($users);
        return view('backend.statistics.index', compact('users'));
    }
    
    public function details($id,Request $request)
    {
        $user = User::findorFail($id);
        $products = null;
        if($user->id_role == 2){
            $products = Product::where('id_user',$id)
                    ->where('id_country', Auth::user()->country_id)
                    ->get();
        }else{
            $products = Product::join('requests','requests.id_product','products.id')
                                ->where('requests.id_user',$id)
                                ->where('requests.is_active','1')
                                ->where('requests.id_country', Auth::user()->country_id)
                                ->get();
            
        }
        
        
        $leads = Lead::join('products','products.id','leads.id_product')->where('leads.id_country', Auth::user()->country_id);
        if($request->id_prod){
            $leads = $leads->where('products.id',$request->id_prod);
        }
        $leads = $leads->where('leads.id_user',$id)->get()->groupby('products.id');//dd($leads);
        return view('backend.statistics.details', compact('leads','products'));
    }
}
