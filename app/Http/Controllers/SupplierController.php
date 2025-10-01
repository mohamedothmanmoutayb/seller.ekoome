<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Lead;
use App\Models\Import;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\WhatsappOffersTemplate;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::where('country_id',Auth::user()->country_id)->where('client_id',Auth::user()->id);

        $items = $request->items ?? 10;
        $suppliers = $suppliers->paginate($items);

        return view('backend.suppliers.index', compact('suppliers','items'));
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
        $data = array();
        $data['country_id'] = Auth::user()->warehouse_id;
        $data['client_id'] = Auth::user()->id;
        $data['name'] = $request->name_supplier;
        $data['phone'] = $request->mobile;
        $data['address'] = $request->address;
        $data['type'] = $request->type;

        Supplier::insert($data);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    public function details(Supplier $supplier)
    {
        $imports = Import::with(['products'])
                    ->where(function($query) use ($supplier) {
                        $query->where('supplier_id', $supplier->id);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10); 
    
        $favoriteProducts = Product::select('products.*', DB::raw('COUNT(lead_products.id_product) as order_count'))
            ->join('lead_products', 'products.id', '=', 'lead_products.id_product')
            ->join('leads', 'lead_products.id_lead', '=', 'leads.id')
            ->where(function($query) use ($supplier) {
                $query->where('leads.client_id', $supplier->id);
            })  
            ->groupBy('products.id')
            ->orderBy('order_count', 'DESC')
            ->limit(5)
            ->get();
    
        $totalSpent = $imports->sum('price');
        $totalOrders = $imports->total();
        $averageOrderValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;

        $templates = WhatsappOffersTemplate::orderBy('name')->get();

        $offerTemplates = WhatsappOffersTemplate::orderBy('name')->get();
        
                
        $products = Product::orderBy('name')->get();
    
        $lastOrderDate = $imports->isEmpty() ? null : $imports->first()->created_at;
        $favoriteCategory = $this->getFavoriteCategory($supplier);
        $averageDaysBetweenOrders = $this->getAverageDaysBetweenOrders($supplier);
        $communications = Communication::where('client_id', $supplier->id)->get();
    
        return view('backend.suppliers.details', compact(
            'supplier', 
            'imports', 
            'favoriteProducts', 
            'totalSpent', 
            'totalOrders', 
            'averageOrderValue',
            'lastOrderDate',
            'favoriteCategory',
            'averageDaysBetweenOrders',
            'templates', 
            'offerTemplates',
            'products',
            'communications'
        ));
    }
    
    private function getFavoriteCategory($supplier)
    {
        return Product::select('categories.name', DB::raw('COUNT(products.id) as count'))
            ->join('categories', 'products.id_category', '=', 'categories.id')
            ->join('lead_products', 'products.id', '=', 'lead_products.id_product')
            ->join('leads', 'lead_products.id_lead', '=', 'leads.id')
            ->where(function($query) use ($supplier) {
                $query->where('leads.phone', $supplier->phone)
                      ->orWhere('leads.phone2', $supplier->phone);
            })
            ->groupBy('categories.name')
            ->orderBy('count', 'DESC')
            ->first();
    }
    
    private function getAverageDaysBetweenOrders($supplier)
    {
        $orderDates = Lead::where('client_id', $supplier->id)
            ->orderBy('created_at')
            ->pluck('created_at');
    
        if ($orderDates->count() < 2) return null;
    
        $totalDays = 0;
        $previousDate = $orderDates->first();
    
        foreach ($orderDates->skip(1) as $date) {
            $totalDays += $previousDate->diffInDays($date);
            $previousDate = $date;
        }
    
        return round($totalDays / ($orderDates->count() - 1), 1);
    }
}
