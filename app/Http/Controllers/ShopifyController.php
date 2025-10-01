<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopifyStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ShopifyController extends Controller
{
    public function index()
    {
        $shopifyStores = ShopifyStore::where('id_country',Auth::user()->country_id)->where('user_id', auth()->id())->get();
        $sellers = User::where('id_role', '2')->get();
        return view('backend.shopify.index', compact('shopifyStores', 'sellers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'shopify_domain' => 'required|string|max:255',
            'api_key' => 'required|string',
            'admin_api_access_token' => 'required|string'
        ]);

        try {
            $store = ShopifyStore::create([
                'user_id' => auth()->id(),
                'id_country' => Auth::user()->country_id,
                'store_name' => $request->store_name,
                'shopify_domain' => $request->shopify_domain,
                'api_key' => $request->api_key,
                'api_version' => $request->api_version ?? '2025-07',
                'admin_api_access_token' => $request->admin_api_access_token,
                'is_active' => false 
            ]);

            $webhookUrl = url("/webhook/shopify/{$store->id}");
            
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $store->admin_api_access_token,
            ])
            ->withBody(json_encode([
                'webhook' => [
                    'topic'   => 'orders/create',
                    'address' => $webhookUrl,
                    'format'  => 'json',
                ],
            ]), 'application/json')
            ->post("https://{$store->shopify_domain}/admin/api/{$store->api_version}/webhooks.json");

            if ($response->successful()) {
                $responseData = $response->json();
                $webhookData = $responseData['webhook'] 
                    ?? ($responseData['webhooks'][0] ?? null);

                if ($webhookData) {
                    $store->update([
                        'webhook_id' => $webhookData['id'],
                        'is_active' => true
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Shopify store and webhook added successfully!'
                ]);
            } else {
                $store->delete();
                
                $error = $response->json()['errors'] ?? 'Unknown error';
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create webhook: ' . json_encode($error)
                ], 500);
            }
        } catch (\Exception $e) {
            if (isset($store)) {
                $store->delete();
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add store: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate(['id' => 'required|exists:shopify_stores,id']);

        $store = ShopifyStore::find($request->id);

        try {
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $store->admin_api_access_token,
                'Content-Type' => 'application/json'
            ])->get("https://{$store->shopify_domain}/admin/api/{$store->api_version}/webhooks.json");
            $webhooks = $response->json()['webhooks'] ?? [];
            $webhookUrl = url("/webhook/shopify/{$store->id}");

            foreach ($webhooks as $webhook) {
                if ($webhook['address'] === $webhookUrl && $webhook['topic'] === 'orders/create') {
                    $store->update([
                        'webhook_id' => $webhook['id'],
                        'is_active' => true
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Webhook verified successfully!'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No matching webhook found. Please setup the webhook first.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error verifying webhook: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|exists:shopify_stores,id']);

        try {
            $store = ShopifyStore::find($request->id);
            
            // Optionally: Delete webhook from Shopify
            if ($store->webhook_id) {
                Http::withHeaders([
                    'X-Shopify-Access-Token' => $store->admin_api_access_token,
                    'Content-Type' => 'application/json'
                ])->delete("https://{$store->shopify_domain}/admin/api/{$store->api_version}/webhooks/{$store->webhook_id}.json");
            }

            $store->delete();

            return response()->json([
                'success' => true,
                'message' => 'Shopify store deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete store: ' . $e->getMessage()
            ], 500);
        }
    }
}

