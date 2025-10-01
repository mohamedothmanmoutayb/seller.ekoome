<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\User;
use App\Models\Citie;
use App\Models\Countrie;
use Illuminate\Support\Facades\Session;
use App\Models\{CountrieFee,IslandZipcode,Import,Store,Product,Stock,Lead,LeadProduct,HistoryStatu,Expense,SpeendAd,Invoice, LightfunnelStore, LightfunnelWebhook, Subscription, YoucanStore ,YoucanWebhook};
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use stdClass;      
    

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $response = Http::asForm()->post('https://wwwcie.ups.com/security/v1/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'Rp8ob8BaiZ7LvVSQ0sXKrpamqXiZAZqi42JYlXJm2H4PNdXl',
            'client_secret' => 'yC913pbOBAWrTgA2NmtEq4RmIsgCcJ3YpnAFNSCdHiAS0Tw6z815hY3hMnpjIwQU',
        ]);
        
        $date_from = $request->date_from ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $date_to = $request->date_to ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $subscription = Subscription::with('plan')->where('user_id', Auth::user()->id)->where('is_active', 1)->first();
        
        $date = Carbon::now()->format('Y-m-d');
        $users = User::where('id_role',2)->select('id','name')->get();
        [$statistics,$satisticsCharts] = $this->statistics($date_from, $date_to); 
        [$totalleads,$totalleadsreturned,$deliveredPercentage,$returnedPercentage,$totalLeadsValueReturned,$totalLeadsValueDelivered] = $this->ordersDiffrence($request, $date_from, $date_to); 
        [$profit,$profitChart,$chifferdaffier] = $this->profitSeller($request, $date_from, $date_to);
        [$orders,$returned,$leads,$OrdersSum,$totalValue,$percentage]= $this->leadsVsorders($date_from, $date_to);
        [$revenues, $expensses, $freeads]= $this->totalRevenue($date_from, $date_to);
        $livrisonrate = $this->shipping($request, $date_from, $date_to);
        $rate=$this->confirmation($request, $date_from, $date_to);
        $earnings = $this->earning($request, $date_from, $date_to);
        ['cities' => $cities, 'orders_count' => $ordersCount] = $this->topCitiesOrders($date_from, $date_to);
        
        $time = Lead::where('type','seller')
                ->where('id_country', Auth::user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->where('status_confirmation','confirmed')
                ->whereBetween('last_status_change', [$date_from, $date_to])
                ->select( DB::raw('COUNT(id) as count ,  HOUR(last_status_change) as hour'))
                ->groupBy('hour')->get();

        $SumConfirmed = Lead::where('id_country',Auth::user()->country_id)
                            ->where('status_confirmation','confirmed')
                            ->whereBetween('created_at', [$date_from, $date_to])
                            ->sum('lead_value');
                            
        $SumDelivered = Lead::where('id_country',Auth::user()->country_id)
                            ->where('status_confirmation','confirmed')
                            ->where('status_livrison','delivered')
                            ->whereBetween('created_at', [$date_from, $date_to])
                            ->sum('lead_value');

        $cacheKey = 'imports_' . Auth::user()->country_id;
        if (Cache::has($cacheKey)) {
            $imports = Cache::get($cacheKey);
        } else {
            $imports = Import::with('product')
                            ->where('status', 'pending')
                            ->where('id_country', Auth::user()->country_id)
                            ->orderBy('date_arrival', 'asc')
                            ->limit(6)
                            ->get();
            Cache::put($cacheKey, $imports, 3600);
        }

        $to = $rate[0] + $rate[2];
        $rateconf = ($to != 0) ? round(($rate[0]/$to) * 100, 0) : 0;
        
        $products = Product::where('id_country',Auth::user()->country_id)->get();
        $month = [date('Y-m') , date('Y-m', strtotime('-1 months')) , date('Y-m', strtotime('-2 months')) , date('Y-m', strtotime('-3 months')) , date('Y-m', strtotime('-4 months')) , date('Y-m', strtotime('-5 months')) , date('Y-m', strtotime('-6 months'))];
        $amountexpensses = Expense::where('id_country',Auth::user()->country_id)
                                ->whereBetween('created_at', [$date_from, $date_from])
                                ->sum('amount') + SpeendAd::wheredate('date','<',$date_from)->wheredate('date','>',$date_from)
                                ->where('country_id', auth()->user()->country_id)
                                ->where('user_id', Auth::user()->id)
                                ->sum('amount');
                                
        $stores = Store::with('Products')->where('id_country',Auth::user()->country_id)->get();
        
        return view('backend.dashboard', compact(
            'users','date','date_from','date_to','imports','statistics','satisticsCharts',
            'totalLeadsValueReturned','totalLeadsValueDelivered','profit','profitChart','chifferdaffier',
            'totalleadsreturned','deliveredPercentage','returnedPercentage','totalleads',
            'rate','livrisonrate','orders','returned','leads','OrdersSum','totalValue','percentage',
            'time','SumConfirmed','SumDelivered','earnings','rateconf','products','month',
            'amountexpensses','freeads','expensses','revenues','stores','cities', 'ordersCount','subscription'
        ));
    }
    
    public function cities(Request $request,$id)
    {
        $empData['data'] = Citie::where('id_country',$id)->select('id','cities.name')->get();
        return response()->json($empData);
    }
    
    public function zones(Request $request,$id)
    {
        $empData['data'] = Zone::where('id_city',$id)->select('id','zones.name')->get();
        return response()->json($empData);
    }

    public function countries($id)
    {
        $data = [
            'country_id' => $id
        ];
        $countries = User::where('id', Auth::user()->id)->update($data);
        return redirect()->back();
    }
    
    public function products(Request $request,$id)
    {
        $empData['data'] = Product::where('id_country', Auth::user()->country_id)->where('id_user',$id)->select('id','products.name')->get();
        return response()->json($empData);
    }

    public function topCitiesOrders($date_from, $date_to)
    {
        $startDate = Carbon::parse($date_from);
        $endDate = Carbon::parse($date_to);

        $topCities = Lead::where('type', 'seller')
            ->where('status_confirmation', 'confirmed')
            ->where('status_livrison', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('id_country', auth()->user()->country_id)
            ->where('id_user', Auth::user()->id)
            ->select('id_city', DB::raw('COUNT(*) as orders_count'))
            ->groupBy('id_city')
            ->orderByDesc('orders_count')
            ->limit(10) 
            ->get();

        $cities = [];
        $ordersCount = [];

        foreach ($topCities as $city) {
            $cityName = Citie::where('id', $city->id_city)->value('name');
            $cities[] = $cityName;
            $ordersCount[] = $city->orders_count;
        }

        return [
            'cities' => $cities,
            'orders_count' => $ordersCount
        ];
    }
    
    public function statistics($date_from, $date_to)
    {
        $totalproducts = Product::where('id_country', Auth::user()->country_id)
                            ->where('id_user', Auth::user()->id)
                            ->whereBetween('created_at', [$date_from, $date_to])
                            ->count();
                            
        $totalusers = User::where('id_role',2)->count();
        
        $leads_counts = Lead::selectRaw('
            SUM(CASE WHEN status_confirmation = "confirmed" THEN 1 ELSE 0 END) as total_leads_confirmed,
            COUNT(leads.id) as total_leads_unconfirmed
        ')->where('type', 'seller')
        ->where('id_country', Auth::user()->country_id)
        ->where('id_user', Auth::user()->id)
        ->where('deleted_at', 0)
        ->whereBetween('created_at', [$date_from, $date_to])
        ->first();

        $totalLeadsConfirmed = $leads_counts->total_leads_confirmed;
        $totalLeadsUnconfirmed = $leads_counts->total_leads_unconfirmed;
        
        $start = Carbon::parse($date_from);
        $end = Carbon::parse($date_to);
        $months = $start->diffInMonths($end);
        $months = min($months, 11); 
        
        $usersChart = [];
        $ordersChart = [];
        $productsChart = [];
        $ordersValueChart = [];
        
        for ($i = 0; $i <= $months; $i++) {
            $monthStart = $end->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $end->copy()->subMonths($i)->endOfMonth();
            
            $queryStart = max($monthStart, $start);
            $queryEnd = min($monthEnd, $end);
            
            $total = User::whereBetween('created_at', [$queryStart, $queryEnd])
                ->where('id', Auth::user()->id)
                ->where('id_role', 2)
                ->count('*');
            $usersChart[$i] = round($total, 2);
            
            $total = Lead::whereBetween('last_contact', [$queryStart, $queryEnd])
                ->where('type', 'seller')
                ->where('id_country', Auth::user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->where('status_confirmation', 'confirmed')
                ->where('deleted_at', 0)
                ->count('*');
            $ordersChart[$i] = round($total, 2);
            
            $total = Product::whereBetween('created_at', [$queryStart, $queryEnd])
                ->where('id_country', Auth::user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->count('*');
            $productsChart[$i] = round($total, 2);
            
            $total = Lead::whereBetween('last_contact', [$queryStart, $queryEnd])
                ->where('type', 'seller')
                ->where('id_country', Auth::user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->where('status_confirmation', '!=', 'confirmed')
                ->where('deleted_at', 0)
                ->count('*');
            $ordersValueChart[$i] = round($total, 2);
        }
        
        $usersChart = array_reverse($usersChart);
        $ordersChart = array_reverse($ordersChart);
        $productsChart = array_reverse($productsChart);
        $ordersValueChart = array_reverse($ordersValueChart);

        $data = [
            $totalusers,
            $totalLeadsConfirmed,
            $totalproducts,
            $totalLeadsUnconfirmed
        ];
        
        $charts = [
            $usersChart,
            $ordersChart,
            $productsChart,
            $ordersValueChart
        ];
        
        return [$data,$charts];
    }

    public function ordersDiffrence(Request $request, $date_from, $date_to)
    {
        $totalLeadsValueDelivered = Lead::where('id_country', Auth::user()->country_id)
                                        ->where('id_user', Auth::user()->id)
                                        ->where('status_livrison','delivered')    
                                        ->where('deleted_at', 0)                                    
                                        ->where('type','seller');
                                        
        $totalLeadsValueReturned = Lead::where('id_country', Auth::user()->country_id)
                                        ->where('id_user', Auth::user()->id)
                                        ->whereIn('status_livrison',['returned','rejected'])   
                                        ->where('deleted_at', 0)                                 
                                        ->where('type','seller');
                                        
        $totalleads = Lead::where('id_country', Auth::user()->country_id)
                                        ->where('id_user', Auth::user()->id)
                                        ->where('status_livrison','delivered')  
                                        ->where('deleted_at', 0)                                         
                                        ->where('type','seller'); 
                                        
        $totalleadsreturned = Lead::where('id_country', Auth::user()->country_id)
                                    ->where('id_user', Auth::user()->id)
                                    ->whereIn('status_livrison',['returned','rejected']) 
                                    ->where('deleted_at', 0)                                      
                                    ->where('type','seller');
                                    
        if($request->period == '1' || $request->period == '0'){
            $startDate = Carbon::now()->subMonths($request->period)->startOfMonth();
            $endDate = Carbon::now()->subMonths($request->period)->endOfMonth(); 

            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereBetween('last_status_delivery',[$startDate, $endDate])
                                 ->sum('lead_value');                                   
                                        
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereBetween('last_status_delivery',[$startDate, $endDate])
                                                                ->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereBetween('last_status_delivery',[$startDate, $endDate])
                                     ->count(); 
                                
            $totalleadsreturned = $totalleadsreturned->whereBetween('last_status_delivery',[$startDate, $endDate])
                                                    ->count();                                     
                                       
        }elseif($request->period == '2'){
            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereYear('last_status_delivery',date('Y'))
                                                                 ->sum('lead_value');                                   
                                        
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereYear('last_status_delivery',date('Y'))
                                                                ->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereYear('last_status_delivery',date('Y'))
                                     ->count(); 
                                
            $totalleadsreturned = $totalleadsreturned->whereYear('last_status_delivery',date('Y'))
                                                    ->count(); 
        } 
        elseif($request->period == '3'){
            $currentYear = Carbon::now()->year;
            $lastYear = $currentYear - 1;
            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereYear('last_status_delivery',$lastYear )
                                                                 ->sum('lead_value');                                   
                                        
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereYear('last_status_delivery',$lastYear )
                                                                ->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereYear('last_status_delivery',$lastYear )
                                     ->count(); 
                                
            $totalleadsreturned = $totalleadsreturned->whereYear('last_status_delivery',$lastYear )
                                                    ->count(); 
        }       
        elseif($request->period == '4'){
            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereDate('last_status_delivery',\Carbon\Carbon::yesterday()->format('Y-m-d'))
                                                                 ->sum('lead_value');                                   
                                        
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereDate('last_status_delivery',\Carbon\Carbon::yesterday()->format('Y-m-d'))
                                                                ->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereDate('last_status_delivery',\Carbon\Carbon::yesterday()->format('Y-m-d'))
                                     ->count(); 
                                
            $totalleadsreturned = $totalleadsreturned->whereDate('last_status_delivery',\Carbon\Carbon::yesterday()->format('Y-m-d'))
                                                    ->count(); 
        }      
        elseif($request->period == '5'){
            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereDate('last_status_delivery',date('Y-m-d'))
                                                                 ->sum('lead_value');                                   
                                        
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereDate('last_status_delivery',date('Y-m-d'))
                                                                ->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereDate('last_status_delivery',date('Y-m-d'))
                                     ->count(); 
                             
            $totalleadsreturned = $totalleadsreturned->whereDate('last_status_delivery',date('Y-m-d'))
                                                    ->count(); 
        } 
        elseif($request->period == '6'){
            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereBetween('last_status_delivery',[Carbon::now()->startOfWeek()->format('Y-m-d') , Carbon::now()->endOfWeek()->format('Y-m-d')])
                                                                 ->sum('lead_value');                                   
                                        
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereBetween('last_status_delivery',[Carbon::now()->startOfWeek()->format('Y-m-d') , Carbon::now()->endOfWeek()->format('Y-m-d')])
                                                                ->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereBetween('last_status_delivery',[Carbon::now()->startOfWeek()->format('Y-m-d') , Carbon::now()->endOfWeek()->format('Y-m-d')])
                                     ->count(); 
                                
            $totalleadsreturned = $totalleadsreturned->whereBetween('last_status_delivery',[Carbon::now()->startOfWeek()->format('Y-m-d') , Carbon::now()->endOfWeek()->format('Y-m-d')])
                                                    ->count(); 
        }   
        elseif($request->period == '7'){
            $currentDate = Carbon::now();
            $currentDate->subWeek();
            $previousWeekStartDate = $currentDate->startOfWeek()->format('Y-m-d');
            $previousWeekEndDate = $currentDate->endOfWeek()->format('Y-m-d');

            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereBetween('last_status_delivery',[$previousWeekStartDate , $previousWeekEndDate ])->sum('lead_value');                                   
                                        
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereBetween('last_status_delivery',[$previousWeekStartDate , $previousWeekEndDate ])->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereBetween('last_status_delivery',[$previousWeekStartDate , $previousWeekEndDate ])->count(); 
                                
            $totalleadsreturned = $totalleadsreturned->whereBetween('last_status_delivery',[$previousWeekStartDate , $previousWeekEndDate ])->count(); 
        } 
        elseif($request->period == '8'){
            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereBetween('last_status_delivery',[Carbon::now()->subMonth(6), Carbon::now()])->sum('lead_value');
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereBetween('last_status_delivery',[Carbon::now()->subMonth(6), Carbon::now()])->sum('lead_value');                                                                                  
            $totalleads = $totalleads->whereBetween('last_status_delivery',[Carbon::now()->subMonth(6), Carbon::now()])->count(); 
                                
            $totalleadsreturned = $totalleadsreturned->whereBetween('last_status_delivery',[Carbon::now()->subMonth(6), Carbon::now()])->count(); 
        }        
        else{
            $totalLeadsValueDelivered = $totalLeadsValueDelivered->whereBetween('last_status_delivery',[$date_from, $date_to])->sum('lead_value');                                   
            $totalLeadsValueReturned = $totalLeadsValueReturned->whereBetween('last_status_delivery',[$date_from, $date_to])->sum('lead_value');  
            $totalleads = $totalleads->whereBetween('last_status_delivery',[$date_from, $date_to])->count(); 
            $totalleadsreturned = $totalleadsreturned->whereBetween('last_status_delivery',[$date_from, $date_to])->count();   
        }

        $totalLeadsValueDelivered   = number_format($totalLeadsValueDelivered,2);
        $totalLeadsValueReturned    = number_format($totalLeadsValueReturned,2);                     
        $totalLeadsCount = $totalleads + $totalleadsreturned;
        
        if ($totalLeadsCount > 0) {
            $deliveredPercentage = number_format(($totalleads / $totalLeadsCount) * 100,1);
            $returnedPercentage = number_format(($totalleadsreturned / $totalLeadsCount) * 100,1);
        } else {
            $deliveredPercentage = 0;
            $returnedPercentage = 0;
        }
        
        return [$totalleads,$totalleadsreturned,$deliveredPercentage,$returnedPercentage,$totalLeadsValueReturned,$totalLeadsValueDelivered];
    }
    
    public function profitSeller(Request $request, $date_from, $date_to)
    {
        $profit = Invoice::where('id_warehouse',Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('date_payment', [$date_from, $date_to]);
                        
        if($request->seller){
            $profit = $profit->where('id_user',$request->seller);
        }
        $profit = $profit->sum('amount');
        
        $profitChart = [];
        $chifferdaffier = [];
        
        for ($i = 1; $i <= 7; $i++) {
            $startDate = Carbon::now()->subMonths($i)->startOfMonth();
            $endDate = Carbon::now()->subMonths($i)->endOfMonth();                                
            $amount = Invoice::whereBetween('date_payment', [$startDate, $endDate])
                            ->where('id_warehouse',auth()->user()->country_id)
                            ->where('id_user', Auth::user()->id);
                            
            if($request->seller){
                $amount = $amount->where('id_user',$request->seller);
            }
            $amount = $amount->sum('amount');
            
            $chiffer = Lead::whereBetween('created_at', [$startDate, $endDate])
                        ->where('id_country',auth()->user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->where('status_confirmation','confirmed');
                        
            if($request->seller){
                $chiffer = $chiffer->where('id_user',$request->seller);
            }
            $chiffer = $chiffer->sum('lead_value');
            
            $profitChart[$i] = round($amount, 2);
            $chifferdaffier[$i] = round($chiffer, 2);
        }                            
        
        return [number_format($profit,2),$profitChart,$chifferdaffier];
    }

    public function earning(Request $request, $date_from, $date_to)
    {
        $total = Lead::where('type','seller')
                    ->where('leads.deleted_at',0)
                    ->where('leads.id_country', Auth::user()->country_id)
                    ->where('id_user', Auth::user()->id)                    
                    ->whereBetween('created_at', [$date_from, $date_to])
                    ->where('status_confirmation','confirmed');
                              
        $delivred_sum = Lead::where('type','seller')
                        ->where('leads.deleted_at',0)
                        ->where('leads.id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('last_status_delivery', [$date_from, $date_to])
                        ->where('status_livrison','delivered');
                        
        if($request->seller){
            $total = $total->where('leads.deleted_at',0)
                        ->where('id_user',$request->seller);      
            $delivred_sum = $delivred_sum->where('leads.deleted_at',0)
                                     ->where('id_user',$request->seller);
        }
        
        $total = number_format((float)$total->sum('lead_value'),2);
        $delivred_sum = number_format((float)$delivred_sum->sum('lead_value'),2);

        return [$total,$delivred_sum];
    }

    public function topSellerByConfirmed(Request $request){
       $currentMonthStart = Carbon::now()->startOfMonth();
       $currentMonthEnd = Carbon::now()->endOfMonth();

       $topSellersByConfirmed = User::select('users.id','users.name', DB::raw('COUNT(leads.id) as total_leads'))
                    ->join('leads', 'users.id', '=', 'leads.id_user')
                    ->where('leads.id_country',auth()->user()->country_id)
                    ->where('leads.status_confirmation', 'confirmed')
                    ->where('leads.deleted_at', 0)
                    ->where('id_role','2');
                    
                    
        if($request->lastmonth){
            $topSellersByConfirmed = $topSellersByConfirmed->whereBetween('leads.last_contact', [Carbon::now(1)->subMonths()->startOfMonth(),Carbon::now(1)->Carbon::now(1)->subMonths()->endOfMonth() ]);
        }elseif($request->year){
            $topSellersByConfirmed = $topSellersByConfirmed->whereYear('leads.last_contact',date('Y') );
        }elseif($request->lyear){
            $currentYear = Carbon::now()->year;
            $lastYear = $currentYear - 1;
            $topSellersByDelivred = $topSellersByDelivred->whereYear('leads.last_contact',$lastYear);
        }
        elseif($request->lsixmonth){
            $topSellersByDelivred = $topSellersByDelivred->whereBetween('leads.last_contact',[Carbon::now()->subMonth(6), Carbon::now()]);
        }
        else{
            $topSellersByConfirmed = $topSellersByConfirmed->whereBetween('leads.last_contact', [Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth() ]);
        }
        $topSellersByConfirmed = $topSellersByConfirmed->groupBy('users.id','users.name')->orderByDesc(DB::raw('COUNT(leads.id)'))->take(5)->get();
        return [$topSellersByConfirmed]; 
    }

    public function topSellerByDelivered(Request $request){
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth(); 
       
        $topSellersByDelivred = User::select('users.id','users.name', DB::raw('COUNT(leads.id) as total_leads'))
                                        ->join('leads', 'users.id', '=', 'leads.id_user')
                                        ->where('leads.id_country',auth()->user()->country_id)
                                        ->where('status_confirmation','confirmed')
                                        ->where('leads.status_livrison', 'delivered')
                                        ->where('leads.deleted_at', 0)
                                        ->where('id_role','2');
                    
        if($request->lastmonthd){
            $topSellersByDelivred = $topSellersByDelivred->whereBetween('leads.last_status_delivery', [Carbon::now(1)->subMonths()->startOfMonth(),Carbon::now(1)->Carbon::now(1)->subMonths()->endOfMonth() ]);
        }elseif($request->yeard){
            $topSellersByDelivred = $topSellersByDelivred->whereYear('leads.last_status_delivery',date('Y'));
        }
        elseif($request->lyeard){
            $currentYear = Carbon::now()->year;
            $lastYear = $currentYear - 1;
            $topSellersByDelivred = $topSellersByDelivred->whereYear('leads.last_status_delivery',$lastYear);
        }
        elseif($request->lsixmonthd){
            $topSellersByDelivred = $topSellersByDelivred->whereBetween('leads.last_status_delivery',[Carbon::now()->subMonth(6), Carbon::now()]);
        }
        else{
            $topSellersByDelivred = $topSellersByDelivred->whereBetween('leads.last_status_delivery', [Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth() ]);
        }
            $topSellersByDelivred = $topSellersByDelivred->groupBy('users.id','users.name')->orderByDesc(DB::raw('COUNT(leads.id)'))->take(5)->get();
         return [$topSellersByDelivred]; 
    }
    
    public function invoiceDonutchart(Request $request=null)
    {
        $cacheKey = 'invoice_counts' . Auth::user()->country_id;
        if (Cache::has($cacheKey)) {
            $invoice_counts = Cache::get($cacheKey);
        } else {
            $invoice_counts = Invoice::selectRaw('
                SUM(CASE WHEN status = "processing" THEN 1 ELSE 0 END) as processing_count,
                SUM(CASE WHEN status = "paid" THEN 1 ELSE 0 END) as paid_count,
                SUM(CASE WHEN status = "unpaid" THEN 1 ELSE 0 END) as unpaid_count
            ')->first();

            Cache::put($cacheKey, $invoice_counts, 3600);
        }

        $processingInvoice = $invoice_counts->processing_count ?? 0;
        $paidInvoice = $invoice_counts->paid_count;
        $unPaidInvoice = $invoice_counts->unpaid_count ?? 0;

        return [$processingInvoice,$paidInvoice,$unPaidInvoice]; 
    }
    
    public function leadsVsorders($date_from, $date_to)
    {
        $orders = [];
        $returned = [];
        $leads = [];

        $startDate = Carbon::parse($date_from)->startOfDay();
        $endDate = Carbon::parse($date_to)->endOfDay();


        $isCurrentMonth = $startDate->isCurrentMonth() && $endDate->isCurrentMonth();

        if ($isCurrentMonth) {

            $daysDifference = $startDate->diffInDays($endDate);
            $maxDaysToShow = min($daysDifference + 1, 31); 
            
            for ($i = 0; $i <= $maxDaysToShow; $i++) {
                $dayDate = $endDate->copy()->subDays($i);
                
                if ($dayDate < $startDate) {
                    continue;
                }

                $queryStart = $dayDate->copy()->startOfDay()->setTimezone('UTC');
                $queryEnd = $dayDate->copy()->endOfDay()->setTimezone('UTC');


                $order = Lead::where('type', 'seller')
                    ->where('status_confirmation', 'confirmed')
                    ->where('status_livrison', 'delivered')
                    ->whereBetween('created_at', [$queryStart, $queryEnd])
                    ->where('id_country', auth()->user()->country_id)
                    ->where('id_user', Auth::user()->id)
                    ->select([
                        DB::raw('COUNT(*) as total_leads'),
                        DB::raw('SUM(lead_value) as leads_value'),
                    ])->where('deleted_at', 0)
                    ->first();
                        
                $orders[$i]['total_leads'] = $order->total_leads ?? 0;
                $orders[$i]['leads_value'] = $order->leads_value ?? 0;
                $orders[$i]['day'] = $dayDate->format('j');
                $orders[$i]['month'] = $dayDate->format('M d'); 

                $return = Lead::where('type', 'seller')
                    ->where('status_confirmation', 'confirmed')
                    ->where('status_livrison', 'returned')
                    ->whereBetween('created_at', [$queryStart, $queryEnd])
                    ->where('id_country', auth()->user()->country_id)
                    ->where('id_user', Auth::user()->id)
                    ->select([
                        DB::raw('COUNT(*) as total_leads'),
                        DB::raw('SUM(lead_value) as leads_value'),
                    ])->where('deleted_at', 0)
                    ->first();
                        
                $returned[$i]['total_leads'] = $return->total_leads ?? 0;
                $returned[$i]['leads_value'] = $return->leads_value ?? 0;
                $returned[$i]['day'] = $dayDate->format('j');
                $returned[$i]['month'] = $dayDate->format('M d');
                $lead = Lead::where('type', 'seller')
                    ->where('status_confirmation', 'confirmed')
                    ->whereBetween('created_at', [$queryStart, $queryEnd])
                    ->where('id_country', auth()->user()->country_id)
                    ->where('id_user', Auth::user()->id)
                    ->select([
                        DB::raw('COUNT(*) as total_leads'),
                        DB::raw('SUM(lead_value) as leads_value'),
                    ])->where('deleted_at', 0)
                    ->first();

                $leads[$i]['total_leads'] = $lead->total_leads ?? 0;
                $leads[$i]['leads_value'] = $lead->leads_value ?? 0;
                $leads[$i]['day'] = $dayDate->format('j');
                $leads[$i]['month'] = $dayDate->format('M d');
            }
        } else {
            $monthsDifference = $startDate->diffInMonths($endDate);
            $monthsToShow = min($monthsDifference + 1, 12); 
            
            for ($i = 0; $i < $monthsToShow; $i++) {
                $monthStart = $endDate->copy()->subMonths($i)->startOfMonth();
                $monthEnd = $endDate->copy()->subMonths($i)->endOfMonth();
                
                if ($monthEnd < $startDate) {
                    continue;
                }
                
                $queryStart = max($monthStart, $startDate);
                $queryEnd = min($monthEnd, $endDate);

                $order = Lead::where('type', 'seller')
                    ->where('status_confirmation', 'confirmed')
                    ->where('status_livrison', 'delivered')
                    ->whereBetween('created_at', [$queryStart, $queryEnd])
                    ->where('id_country', auth()->user()->country_id)
                    ->where('id_user', Auth::user()->id)
                    ->select([
                        DB::raw('COUNT(*) as total_leads'),
                        DB::raw('SUM(lead_value) as leads_value'),
                    ])->where('deleted_at', 0)
                    ->first();
                        
                $orders[$i]['total_leads'] = $order->total_leads ?? 0;
                $orders[$i]['leads_value'] = $order->leads_value ?? 0;
                $orders[$i]['month'] = $monthEnd->format('M Y'); 

                $return = Lead::where('type', 'seller')
                    ->where('status_confirmation', 'confirmed')
                    ->where('status_livrison', 'returned')
                    ->whereBetween('created_at', [$queryStart, $queryEnd])
                    ->where('id_country', auth()->user()->country_id)
                    ->where('id_user', Auth::user()->id)
                    ->select([
                        DB::raw('COUNT(*) as total_leads'),
                        DB::raw('SUM(lead_value) as leads_value'),
                    ])->where('deleted_at', 0)
                    ->first();
                        
                $returned[$i]['total_leads'] = $return->total_leads ?? 0;
                $returned[$i]['leads_value'] = $return->leads_value ?? 0;
                $returned[$i]['month'] = $monthEnd->format('M Y');
                
                $lead = Lead::where('type', 'seller')
                    ->where('status_confirmation', 'confirmed')
                    ->whereBetween('created_at', [$queryStart, $queryEnd])
                    ->where('id_country', auth()->user()->country_id)
                    ->where('id_user', Auth::user()->id)
                    ->select([
                        DB::raw('COUNT(*) as total_leads'),
                        DB::raw('SUM(lead_value) as leads_value'),
                    ])->where('deleted_at', 0)
                    ->first();

                $leads[$i]['total_leads'] = $lead->total_leads ?? 0;
                $leads[$i]['leads_value'] = $lead->leads_value ?? 0;
                $leads[$i]['month'] = $monthStart->format('M Y');
            }
        }
        
        $orders = array_reverse($orders);
        $returned = array_reverse($returned);
        $leads = array_reverse($leads);
        
        $totalValue = [
            array_sum(array_column($orders, 'leads_value')), 
            array_sum(array_column($leads, 'leads_value'))
        ];
        
        $OrdersSum = [
            array_sum(array_column($orders, 'total_leads')),
            array_sum(array_column($leads, 'total_leads'))
        ];
        
        if (count($orders) > 1) {
            $difference = $orders[count($orders)-1]['total_leads'] - $orders[count($orders)-2]['total_leads'];
            $percentage = ($orders[count($orders)-2]['total_leads'] == 0) ? 100 : ($difference * 100 / $orders[count($orders)-2]['total_leads']);
        } else {
            $percentage = 0;
        }
        
        $percentage = number_format($percentage, 2);


        return [
            $orders,
            $returned,
            $leads,
            $OrdersSum,
            $totalValue,
            $percentage
        ]; 
    }
    
public function totalRevenue($date_from, $date_to)
{
    $expenses = [];
    $freeads = [];
    $revenues = [];

    $startDate = Carbon::parse($date_from);
    $endDate = Carbon::parse($date_to);

    $isCurrentMonth = $startDate->isCurrentMonth() && $endDate->isCurrentMonth();

    if ($isCurrentMonth) {
        $daysDifference = $startDate->diffInDays($endDate);
        $maxDaysToShow = min($daysDifference + 1, 31);
        
        $dayCounter = 0;
        
        for ($i = 0; $i <= $daysDifference; $i++) {
            $dayDate = $endDate->copy()->subDays($i);
            
            if ($dayDate < $startDate) {
                continue;
            }

            $queryStart = $dayDate->copy()->startOfDay();
            $queryEnd = $dayDate->copy()->endOfDay();


            $sumrevenue = Lead::where('type', 'seller')
                ->where('status_confirmation', 'confirmed')
                ->where('status_livrison', 'delivered')
                ->whereBetween('created_at', [$queryStart, $queryEnd])
                ->where('id_country', auth()->user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->sum('lead_value');
                
            $revenues[$dayCounter]['value'] = $sumrevenue ?? 0;
            $revenues[$dayCounter]['date'] = $dayDate->format('M d');
            $revenues[$dayCounter]['day'] = $dayDate->format('j');

            $sumexpenses = Expense::whereBetween('created_at', [$queryStart, $queryEnd])
                ->where('id_country', auth()->user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->sum('amount');
        
            $expenses[$dayCounter] = $sumexpenses ?? 0;
            
            $amountfreeads = SpeendAd::whereBetween('date', [$queryStart, $queryEnd])
                ->where('country_id', auth()->user()->country_id)
                ->where('user_id', Auth::user()->id)
                ->sum('amount');
                
            $freeads[$dayCounter] = $amountfreeads ?? 0;
            
            $dayCounter++;
        }
    } else {
        $monthsDifference = $startDate->diffInMonths($endDate);
        $monthsToShow = min($monthsDifference + 1, 12); 
        
        for ($i = 0; $i <= $monthsToShow; $i++) {
            $monthStart = $endDate->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $endDate->copy()->subMonths($i)->endOfMonth();
            
            if ($monthEnd < $startDate) {
                continue;
            }
            
            $queryStart = max($monthStart, $startDate);
            $queryEnd = min($monthEnd, $endDate);

            $sumrevenue = Lead::where('type', 'seller')
                ->where('status_confirmation', 'confirmed')
                ->where('status_livrison', 'delivered')
                ->whereBetween('created_at', [$queryStart, $queryEnd])
                ->where('id_country', auth()->user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->sum('lead_value');
                
            $revenues[$i]['value'] = $sumrevenue ?? 0;
            $revenues[$i]['date'] = $monthStart->format('M Y'); 

            $sumexpenses = Expense::whereBetween('created_at', [$queryStart, $queryEnd])
                ->where('id_country', auth()->user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->sum('amount');
        
            $expenses[$i] = $sumexpenses ?? 0;
            
            $amountfreeads = SpeendAd::whereBetween('date', [$queryStart, $queryEnd])
                ->where('country_id', auth()->user()->country_id)
                ->sum('amount');
                
            $freeads[$i] = $amountfreeads ?? 0;
        }
    }
    
    $revenues = array_reverse($revenues);
    $expenses = array_reverse($expenses);
    $freeads = array_reverse($freeads);
    
    return [$revenues, $expenses, $freeads]; 
}
    public function countrevenu(Request $request)
    {
        $revenue = Lead::where('id_country', Auth::user()->country_id)
                    ->where('id_user', Auth::user()->id)
                    ->where('status_confirmation','confirmed')
                    ->where('status_livrison','delivered')
                    ->whereIn('status_payment',['no paid','paid service']);
                    
        if(!empty($request->seller)){
            $revenue = $revenue->where('id_user',$request->seller);
        }
        
        $revenutopay= $revenue->sum('lead_value') - ($revenue->sum('fees_confirmation') + $revenue->sum('fees_livrison') + $revenue->sum('fees_cod'));
        $countrevenu=$revenue->count(); 
        
        $data[]=[
            $revenutopay,
            $countrevenu,
        ];
        
        return [$data]; 
    }
    
    public function confirmation(Request $request, $date_from, $date_to)
    {
        $confirmed = Lead::where('type','seller')
                        ->where('status_confirmation','confirmed')
                        ->where('leads.deleted_at',0)
                        ->where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
                        
        $canceled = Lead::where('type','seller')
                        ->where('status_confirmation','canceled')
                        ->where('leads.deleted_at',0)
                        ->where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
                        
        $new_lead = Lead::where('type','seller')
                        ->where('leads.deleted_at',0)
                        ->where('status_confirmation','new order')
                        ->where('leads.id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
                        
        $canceledbysystem = Lead::where('type','seller')
                        ->where('status_confirmation','canceled by system')
                        ->where('leads.deleted_at',0)
                        ->where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
    
        if($request->seller){
            $confirmed = $confirmed->where('id_user',$request->seller);
            $canceled = $canceled->where('id_user',$request->seller);
            $new_lead = $new_lead->where('id_user',$request->seller);
        }
        
        if($request->data_product_confirmation){
            $confirmed = $confirmed->where('id_product',$request->data_product_confirmation);
            $canceled = $canceled->where('id_product',$request->data_product_confirmation);
            $new_lead = $new_lead->where('id_product',$request->data_product_confirmation);
        }
        
        $confirmed = $confirmed->count();
        $canceled = $canceled->count();
        $canceledbysystem = $canceledbysystem->count();
        $new_lead = $new_lead->count();

        $data2 = ($confirmed == 0) ? 0 : round((float)($confirmed/($confirmed + $canceled + $canceledbysystem))*100);
        $data3 = $canceled;
        $data4 = ($canceled == 0) ? 0 : round((float)($canceled/($confirmed + $canceled + $canceledbysystem))*100);
        $data5 = ($canceledbysystem == 0) ? 0 : round((float)($canceledbysystem/($confirmed + $canceled + $canceledbysystem))*100);
       
        $data =[
            $confirmed,
            $data2,
            $canceled,
            $data4,
            $new_lead,
            $canceledbysystem,
            $data5
        ];
      
        return $data;
    }
    
    public function shipping(Request $request, $date_from, $date_to)
    {

        $returned = Lead::where('type','seller')
                        ->where('leads.deleted_at',0)
                        ->where('status_livrison','returned')
                        ->where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
                        
        $processed = Lead::where('type','seller')
                        ->where('leads.deleted_at',0)
                        ->where('status_livrison','proseccing')
                        ->where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
                        
        $delivered = Lead::where('type','seller')
                        ->where('leads.deleted_at',0)
                        ->where('status_confirmation','confirmed')
                        ->where('status_livrison','delivered')
                        ->where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
                        
        $intransit = Lead::where('type','seller')
                        ->where('leads.deleted_at',0)
                        ->where('status_livrison','in transit')
                        ->where('id_country', Auth::user()->country_id)
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
                        
        $sum_lead = Lead::where('type','seller')
                        ->where('leads.deleted_at',0)
                        ->where('leads.id_country', Auth::user()->country_id)
                        ->where('status_confirmation','confirmed')
                        ->where('status_livrison','delivered')
                        ->where('id_user', Auth::user()->id)
                        ->whereBetween('created_at', [$date_from, $date_to]);
       
        if($request->seller){
            $returned = $returned->where('id_user',$request->seller);
            $processed = $processed->where('id_user',$request->seller);
            $delivered = $delivered->where('id_user',$request->seller);
            $intransit = $intransit->where('id_user',$request->seller);
            $sum_lead = $sum_lead->where('id_user', $request->seller);
        }
        
        if($request->product_shipping){
            $returned = $returned->where('id_product',$request->product_shipping);
            $processed = $processed->where('id_product',$request->product_shipping);
            $delivered = $delivered->where('id_product',$request->product_shipping);
            $intransit = $intransit->where('id_product',$request->product_shipping);
            $sum_lead = $sum_lead->where('id_product',$request->product_shipping);
        }

        
        $returned = $returned->count();
        $processed = $processed->count();
        $delivered = $delivered->count();
        $intransit = $intransit->count();
        $sum_lead = $sum_lead->sum('lead_value');


        if($delivered !=0 || $processed != 0 || $returned != 0){
            $processedrate = round((float)($processed/($processed + $delivered + $returned +$intransit ))*100);
            $deliveredrate = round((float)($delivered/($delivered + $returned) )*100);
            $returnedrate = round((float)($returned/($delivered + $returned))*100);
            $intransitrate = round((float)($intransit/($delivered + $returned + $processed+$intransit))*100);
        }else{
            $processedrate = 0;
            $deliveredrate = 0;
            $returnedrate = 0;
            $intransitrate = 0;
        }

        $sum_lead  = number_format((float)($sum_lead) , 2);
        $data=[ $processed, $processedrate, $delivered, $deliveredrate, $returned, $returnedrate,$intransit,$intransitrate,$sum_lead];
        
        return $data;
    }
    
    public function processed(Request $request)
    {
        $feess = CountrieFee::where('id_country',Auth::user()->country_id)
                            ->where('id_user',$request->seller)
                            ->first();
                            
        $order = Lead::where('id_country', Auth::user()->country_id)
                    ->where('status_confirmation','!=','new order');
                    
        if($request->year){
            $parts = explode(' - ' , $request->year);
            $date_from = $parts[0];
            if(!empty($parts[1])){
                $date_two = $parts[1];
            }else{
                $date_two = $parts[0];
            }
            $order = $order->whereBetween('created_at',[$date_from , $date_two]);
        }
        
        $count = $order->where('id_user',$request->seller)->count();
        $total = $order->where('id_user',$request->seller)->sum('lead_value');
        $percentage=(($feess->percentage) * $total ) / 100 ;
        $sum = $total - ((($feess->fees_confirmation + $feess->fess_shipping) * $count) + $percentage);
        
        $data[]=[
            $count,
            $sum,
        ];
        
        return response()->json($data);
    }
    
    public function totalorder(Request $request)
    {
        $order = Lead::where('id_country', Auth::user()->country_id);
        
        if($request->product){
            $order = $order->where('id_product',$request->product);
        }
        
        if($request->seller){
            $order = $order->where('id_user',$request->seller);
        }
        
        if($request->year){
            $parts = explode(' - ' , $request->year);
            $date_from = $parts[0];
            if(!empty($parts[1])){
                $date_two = $parts[1];
            }else{
                $date_two = $parts[0];
            }
            
            if($date_two == $date_from){
                $order = $order->whereDate('created_at',$date_from );
            }else{
                $order = $order->whereBetween('created_at',[$date_from , $date_two]);
            }
        }
        
        $order = $order->count();
        return response()->json($order);
    }

    public function ajaxDashboard(Request $request)
    {
        $date_from = $request->date_from ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $date_to = $request->date_to ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $subscription = Subscription::with('plan')->where('user_id',Auth::user()->id)->first();
        
        [$statistics,$satisticsCharts] = $this->statistics($date_from, $date_to); 
        [$totalleads,$totalleadsreturned,$deliveredPercentage,$returnedPercentage,$totalLeadsValueReturned,$totalLeadsValueDelivered] = $this->ordersDiffrence($request, $date_from, $date_to); 
        [$profit,$profitChart,$chifferdaffier] = $this->profitSeller($request, $date_from, $date_to);
        [$orders,$returned,$leads,$OrdersSum,$totalValue,$percentage]= $this->leadsVsorders($date_from, $date_to);
        [$revenues, $expensses, $freeads]= $this->totalRevenue($date_from, $date_to);
        $livrisonrate = $this->shipping($request, $date_from, $date_to);
        $rate=$this->confirmation($request, $date_from, $date_to);
        $earnings = $this->earning($request, $date_from, $date_to);
        ['cities' => $cities, 'orders_count' => $ordersCount] = $this->topCitiesOrders($date_from, $date_to);

        
        $time = Lead::where('type','seller')
                ->where('id_country', Auth::user()->country_id)
                ->where('id_user', Auth::user()->id)
                ->where('status_confirmation','confirmed')
                ->whereBetween('last_status_change', [$date_from, $date_to])
                ->select( DB::raw('COUNT(id) as count ,  HOUR(last_status_change) as hour'))
                ->groupBy('hour')->get();

        $SumConfirmed = Lead::where('id_country',Auth::user()->country_id)
                            ->where('status_confirmation','confirmed')
                            ->whereBetween('created_at', [$date_from, $date_to])
                            ->sum('lead_value');
                            
        $SumDelivered = Lead::where('id_country',Auth::user()->country_id)
                            ->where('status_confirmation','confirmed')
                            ->where('status_livrison','delivered')
                            ->whereBetween('created_at', [$date_from, $date_to])
                            ->sum('lead_value');

        $amountexpensses = Expense::where('id_country',Auth::user()->country_id)
                                ->whereBetween('created_at', [$date_from, $date_to])
                                ->sum('amount') + SpeendAd::whereBetween('date', [$date_from, $date_to])
                                ->where('country_id', auth()->user()->country_id)
                                ->where('user_id', Auth::user()->id)
                                ->sum('amount');
        
        $to = $rate[0] + $rate[2];
        $rateconf = ($to != 0) ? round(($rate[0]/$to) * 100, 0) : 0;
        
        return response()->json([
            'statistics' => $statistics,
            'cities' => $cities,
            'ordersCount' => $ordersCount,
            'satisticsCharts' => $satisticsCharts,
            'totalLeadsValueReturned' => $totalLeadsValueReturned,
            'totalLeadsValueDelivered' => $totalLeadsValueDelivered,
            'profit' => $profit,
            'profitChart' => $profitChart,
            'chifferdaffier' => $chifferdaffier,
            'totalleadsreturned' => $totalleadsreturned,
            'deliveredPercentage' => $deliveredPercentage,
            'returnedPercentage' => $returnedPercentage,
            'totalleads' => $totalleads,
            'rate' => $rate,
            'livrisonrate' => $livrisonrate,
            'orders' => $orders,
            'returned' => $returned,
            'leads' => $leads,
            'OrdersSum' => $OrdersSum,
            'totalValue' => $totalValue,
            'percentage' => $percentage,
            'SumConfirmed' => $SumConfirmed,
            'SumDelivered' => $SumDelivered,
            'earnings' => $earnings,
            'rateconf' => $rateconf,
            'amountexpensses' => $amountexpensses,
            'freeads' => $freeads,
            'expensses' => $expensses,
            'revenues' => $revenues,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'subscription' => $subscription,
        ]);
    }
}