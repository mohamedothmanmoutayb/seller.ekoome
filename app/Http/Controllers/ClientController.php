<?php

namespace App\Http\Controllers;

use App\Models\Citie;
use App\Models\Client;
use App\Models\Communication;
use App\Models\Countrie;
use App\Models\Lead;
use App\Models\Product;
use App\Models\WhatsAppAccount;
use App\Models\WhatsappOffersTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        
        $country_id = Auth::user()->country_id;
        $clients = Client::with('leads') 
                ->where('id_country', $country_id)
                ->where('id_user', Auth::id())
                ->orderBy('created_at', 'DESC');
    

        if ($request->filled('name')) {
            $clients->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('phone')) {
            $clients->where(function($query) use ($request) {
                $query->where('phone1', 'like', '%'.$request->phone.'%')
                    ->orWhere('phone2', 'like', '%'.$request->phone.'%');
            });
        }


        $items = $request->items ?? 10;
        $clients = $clients->paginate($items);

        return view('backend.clients.index', compact('clients', 'items'));
    }

    public function export() {
       return response()->json([
            'status' => 'success',
            'message' => 'Export functionality is not implemented yet.'
        ]);
    }

    public function details(Client $client)
    {
        $leads = Lead::with(['products', 'historystatu', 'deliveryattempts'])
                    ->where(function($query) use ($client) {
                        $query->where('client_id', $client->id);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10); 

        $whatsappAccounts = WhatsAppAccount::where('country_id', $client->id_country)->where('user_id', $client->id_user)
                    ->get();
    
        $favoriteProducts = Product::select('products.*', DB::raw('COUNT(lead_products.id_product) as order_count'))
            ->join('lead_products', 'products.id', '=', 'lead_products.id_product')
            ->join('leads', 'lead_products.id_lead', '=', 'leads.id')
            ->where(function($query) use ($client) {
                $query->where('leads.client_id', $client->id);
            })  
            ->groupBy('products.id')
            ->orderBy('order_count', 'DESC')
            ->limit(5)
            ->get();
    
        $totalSpent = $leads->sum('lead_value');
        $totalOrders = $leads->total();
        $averageOrderValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;

        $templates = WhatsappOffersTemplate::orderBy('name')->get();

        $offerTemplates = WhatsappOffersTemplate::orderBy('name')->get();
        
                
        $products = Product::orderBy('name')->get();
    
        $lastOrderDate = $leads->isEmpty() ? null : $leads->first()->created_at;
        $favoriteCategory = $this->getFavoriteCategory($client);
        $averageDaysBetweenOrders = $this->getAverageDaysBetweenOrders($client);
        $communications = Communication::where('client_id', $client->id)->get();
    
        return view('backend.clients.details', compact(
            'client', 
            'leads', 
            'favoriteProducts', 
            'totalSpent', 
            'totalOrders', 
            'averageOrderValue',
            'lastOrderDate',
            'favoriteCategory',
            'averageDaysBetweenOrders',
            'templates', 
            'whatsappAccounts', 
            'offerTemplates',
            'products',
            'communications'
        ));
    }
    
    private function getFavoriteCategory($client)
    {
        return Product::select('categories.name', DB::raw('COUNT(products.id) as count'))
            ->join('categories', 'products.id_category', '=', 'categories.id')
            ->join('lead_products', 'products.id', '=', 'lead_products.id_product')
            ->join('leads', 'lead_products.id_lead', '=', 'leads.id')
            ->where(function($query) use ($client) {
                $query->where('leads.phone', $client->phone)
                      ->orWhere('leads.phone2', $client->phone);
            })
            ->groupBy('categories.name')
            ->orderBy('count', 'DESC')
            ->first();
    }
    
    private function getAverageDaysBetweenOrders($client)
    {
        $orderDates = Lead::where('client_id', $client->id)
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

    public function sendOffers() {
        return response()->json('Hi');
    }

    public function addNote(Client $client, Request $request)
    {
        $request->validate([
            'seller_notes' => 'nullable|string'
        ]);
    
        try {
            $client->update([
                'seller_notes' => $request->seller_notes
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Notes updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
}
