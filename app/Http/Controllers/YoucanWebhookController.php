<?php

namespace App\Http\Controllers;

use App\Events\NewLeadCreated;
use App\Models\Client;
use App\Models\Countrie;
use App\Models\HistoryStatu;
use App\Models\Lead;
use App\Models\LeadProduct;
use App\Models\LightfunnelStore;
use App\Models\Product;
use App\Models\YoucanStore;
use App\Models\User;
use App\Models\Zipcode;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YoucanWebhookController extends Controller
{

    
public function OrderCreatedYoucan(Request $request)
{
    $payload = json_decode($request->getContent(), true);
    Log::info("Order : " . json_encode($payload));

    $date = new DateTime();

    if (!isset($payload['id'])) {
        Log::warning("Invalid payload structure: 'id' key missing");
        return response()->json(['message' => 'Invalid payload structure'], 400);
    }

    $orderId = $payload['id'];
    $orderTotal = $payload['total'] ?? 0;
    $orderCreatedAt = $payload['created_at'] ?? $date->format('Y-m-d H:i:s');
    $storeId = $payload['store_id'] ?? null;

    $account = YoucanStore::where('store_id', $storeId)->first();
    if (!$account) {
        Log::error("Account not found: $storeId");
        return response()->json(['message' => 'Account not found'], 404);
    }

    $user = User::find($account->user_id);
    if (!$user) {
        Log::error("User not found for account: $storeId");
        return response()->json(['message' => 'User not found'], 404);
    }

    if (Lead::where('id_order', $orderId)->where('id_user', $user->id)->exists()) {
        Log::info("Order already exists: $orderId");
        return response()->json(['message' => 'Order already processed'], 200);
    }

    $customer = $payload['customer'] ?? [];
    $phone = $customer['phone'] ?? null;

    $client = Client::where('phone1', $phone)->first();
    if (!$client) {
        $client = new Client();
        $client->firstname = $customer['first_name'] ?? '';
        $client->lastname = $customer['last_name'] ?? '';
        $client->phone1 = $phone;
        $client->country = $customer['country'] ?? '';
        $client->city = $customer['city'] ?? '';
        $client->address1 = $customer['location'] ?? '';
        $client->email = $customer['email'] ?? null;
        $client->user_id = $user->id;
        $client->save();
    }

    $lead = new Lead();
    $lead->id_user = $user->id;
    $lead->id_client = $client->id;
    $lead->id_order = $orderId;
    $lead->amount = $orderTotal;
    $lead->payment_status = $payload['payment_status_new'] ?? 'unpaid';
    $lead->order_status = $payload['status_new'] ?? 'open';
    $lead->created_at_store = $orderCreatedAt;
    $lead->store_id = $storeId;
    $lead->platform = 'youcan';
    $lead->save();

    if (isset($payload['variants'])) {
        foreach ($payload['variants'] as $variant) {
            if (!isset($variant['variant']['product'])) {
                continue;
            }
            $product = $variant['variant']['product'];

            $leadProduct = new LeadProduct();
            $leadProduct->lead_id = $lead->id;
            $leadProduct->product_name = $product['name'] ?? '';
            $leadProduct->product_price = $variant['price'] ?? 0;
            $leadProduct->product_image = $product['thumbnail'] ?? null;
            $leadProduct->product_quantity = $variant['quantity'] ?? 1;
            $leadProduct->save();
        }
    }

    return response()->json(['message' => 'Order processed successfully'], 200);
}


 
}

