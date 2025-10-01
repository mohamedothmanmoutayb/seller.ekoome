<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YoucanAccount;
use App\Models\YoucanStore;
use App\Models\YoucanWebhook;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class YouCanController extends Controller
{
    public function index(Request $request)
    {
        $stores = YoucanStore::with(['account', 'webhooks'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('backend.youcan.index', compact('stores'));
    }

    public function youcanCallback(Request $request)
    {
        if ($request->has('error')) {
            if ($request->get('error') === 'access_denied') {
                return 'Authorization canceled by user';
            }
            return "Authorization error occurred";
        }
    
        $http = new Client;
    
        try {
            $response = $http->post('https://api.youcan.shop/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('YOUCAN_CLIENT_ID'),
                    'client_secret' => env('YOUCAN_CLIENT_SECRET'),
                    'redirect_uri' => env('YOUCAN_REDIRECT_URI'),
                    'code' => $request->get('code'),
                ],
                'http_errors' => false
            ]);
    
            $result = json_decode((string)$response->getBody(), true);
            
            if (isset($result['error'])) {
                \Log::error('YouCan OAuth Error', $result);
                return response()->json(['error' => 'OAuth failed'], 400);
            }
            $target_url = request()->root() . '/webhook/youcan';
            $webhookResponse = $this->registerYoucanWebhook($result['access_token'], $target_url);
            dd($webhookResponse);
            return $webhookResponse;
    
        } catch (\Exception $e) {
            \Log::error('YouCan OAuth Exception', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Authentication failed'], 500);
        }
    }

    public function destroy($storeId)
    {
        $store = YoucanStore::with('webhooks')->findOrFail($storeId);
        
        try {
            new Client();
            
            foreach ($store->webhooks as $webhook) {
                $this->unsubscribeWebhookFromYouCan($store->access_token, $webhook->webhook_id);
            }

            
            $store->webhooks()->delete();
            
            $store->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Store and all webhooks unsubscribed successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    protected function unsubscribeWebhookFromYouCan($accessToken, $webhookId)
    {
        $client = new Client();
        
        try {
            $response = $client->post(
                "https://api.youcan.shop/resthooks/unsubscribe/{$webhookId}",
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json',
                    ],
                    'http_errors' => false
                ]
            );
            
            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Failed to unsubscribe webhook: " . $response->getBody());
            }
            
            return true;
            
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                return true;
            }
            throw $e;
        }
    }

    // public function youcanAuth(Request $request)
    // {
    //     $validated = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $http = new Client();

    //     try {
    //         $response = $http->post(
    //             'https://api.youcan.shop/auth/login',
    //             [
    //                 'headers' => [
    //                     'Content-Type' => 'application/json',
    //                     'Accept' => 'application/json',
    //                 ],
    //                 'json' => [
    //                     'email' => $validated['email'],
    //                     'password' => $validated['password'],
    //                 ],
    //                 'http_errors' => false,
    //             ]
    //         );

    //         if ($response->getStatusCode() !== 200) {
    //             $error = json_decode((string)$response->getBody(), true);
    //             dd($error);
    //             return back()->with('error', $error['message'] ?? 'Authentication failed');
    //         }

    //         $authData = json_decode((string)$response->getBody(), true);

    //         $user = Auth::user();
    //         $account = YoucanAccount::updateOrCreate(
    //             ['user_id' => $user->id, 'email' => $validated['email']],
    //             [
    //                 'password' => Hash::make($validated['password']), 
    //                 'account_token' => $authData['token'],
    //                 'token_type' => $authData['token_type'],
    //                 'is_staff' => $authData['is_staff'],
    //                 'expired_at' => $authData['expired_at'],
    //             ]
    //         );


    //         foreach ($authData['stores'] as $storeData) {
    //             $target_url = request()->root() . '/webhook/youcan';
                
    //             $store = YoucanStore::updateOrCreate(
    //                 ['store_id' => $storeData['store_id']],
    //                 [
    //                     'account_id' => $account->id,
    //                     'slug' => $storeData['slug'],
    //                     'is_active' => $storeData['is_active'],
    //                     'is_email_verified' => $storeData['is_email_verified'],
    //                     'country_id' => $user->country_id,
    //                 ]
    //             );

    //             $webhookResponse = $this->registerYoucanWebhook($authData['token'], $target_url);
                
    //             if ($webhookResponse) {
    //                 YoucanWebhook::updateOrCreate(
    //                     ['store_id' => $store->id, 'event' => 'order.create'],
    //                     [
    //                         'webhook_id' => $webhookResponse['id'],
    //                         'target_url' => $target_url,
    //                     ]
    //                 );
    //             }
    //         }

    //        return response()
    //             ->json([
    //                 'success' => true,
    //                 'message' => 'YouCan webhook registered successfully',
    //             ]);

    //     } catch (\Exception $e) {
    //         dd($e->getMessage());
    //         return back()->with('error', 'An error occurred: ' . $e->getMessage());
    //     }
    // }


    // private function registerYoucanWebhook($accessToken, $targetUrl)
    // {
    //     $http = new Client();

    //     $response = $http->post(
    //         'https://api.youcan.shop/resthooks/subscribe',
    //         [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $accessToken,
    //                 'Content-Type' => 'application/json',
    //                 'Accept' => 'application/json',
    //             ],
    //             'json' => [
    //                 'target_url' => $targetUrl,
    //                 'event' => 'order.create',
    //             ],
    //             'http_errors' => false,
    //         ]
    //     );

    //     if ($response->getStatusCode() === 200) {
    //         return json_decode((string)$response->getBody(), true);
    //     }

    //     return null;
    // }

}
