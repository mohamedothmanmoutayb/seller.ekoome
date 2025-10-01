<?php

namespace App\Http\Controllers;

use App\Models\LightfunnelsAccount;
use Illuminate\Http\Request;
use App\Models\LightfunnelStore;
use App\Models\User;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LightfunnelsController extends Controller
{
    public function index(Request $request)
    {
        $stores = LightfunnelStore::with('lightfunnelWebhooks')->get();
        return view('backend.Lightfunnels.index', compact('stores'));
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:lightfunnel_stores,id',
        ]);
        
        try {
            $store = LightfunnelStore::findOrFail($request->store_id);
            
            $store->is_active = !$store->is_active;
            $store->save();

            return response()->json([
                'success' => true,
                'new_status' => $store->is_active, 
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
}
