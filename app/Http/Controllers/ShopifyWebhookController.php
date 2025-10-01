<?php

namespace App\Http\Controllers;

use App\Events\NewLeadCreated;
use App\Models\Client;
use App\Models\Countrie;
use App\Models\HistoryStatu;
use App\Models\Lead;
use App\Models\LeadProduct;
use App\Models\Notification;
use App\Models\Product;
use App\Models\ShopifyStore;
use App\Models\User;
use App\Models\Zipcode;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class ShopifyWebhookController extends Controller
{
    public function OrderCreatedShopify(Request $request, $storeId)
    {
        $payload = json_decode($request->getContent(), true);
        $payload['source'] = 'shopify';
        $date = new DateTime();
        
        Log::info("Shopify Order Created for store $storeId: " . json_encode($payload));
        
        $order = $payload;
        $orderId = $order['id'] ?? null;
        
        $shopifyStore = ShopifyStore::find($storeId);
        if (!$shopifyStore) {
            Log::error("Shopify store not found: $storeId");
            return response()->json(['message' => 'Shopify store not found'], 404);
        }
        
        $user = $shopifyStore->user;
        if (!$user) {
            Log::error("User not found for Shopify store: $storeId");
            return response()->json(['message' => 'User not found'], 404);
        }
        
        $payload['playSound'] = optional($user->notificationSetting)->sound ?? true;
        
        if (Lead::where('id_order', $orderId)->where('id_user', $user->id)->exists()) {
            Log::info("Order already exists: $orderId");
            
            $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'warning',
                'title' => 'Order already processed',
                'message' => "Order ID: $orderId from Shopify store: {$shopifyStore->store_name}",
                'payload' => json_encode($payload)
            ]);

            $this->triggerPusherNotification($user->id, $notification);
            return response()->json(['message' => 'Order already processed'], 200);
        }

        $customer = $order['customer'] ?? [];
        $shippingAddress = $order['shipping_address'] ?? [];
        $billingAddress = $order['billing_address'] ?? [];

        $noteAttributes = $order['note_attributes'] ?? [];
        $customerName = null;
        $customerPhone = null;
        $customerAddress = null;

        foreach ($noteAttributes as $attribute) {
            switch ($attribute['name']) {
                case 'الإسم الكامل': 
                case 'Full Name':
                case 'name':
                    $customerName = $attribute['value'];
                    break;
                case 'الهاتف':
                case 'Phone':
                case 'phone':
                    $customerPhone = $attribute['value'];
                    break;
                case 'العنوان': 
                case 'Address':
                case 'address':
                    $customerAddress = $attribute['value'];
                    break;
            }
        }

        $phone = $shippingAddress['phone'] ?? $billingAddress['phone'] ?? $customer['phone'] ?? $customerPhone ?? null;
        $email = $customer['email'] ?? $order['contact_email'] ?? null;

        $fullName = $customerName ?? 
                ($shippingAddress['first_name'] ?? $customer['first_name'] ?? '') . ' ' . 
                ($shippingAddress['last_name'] ?? $customer['last_name'] ?? '');

        $address = $customerAddress ?? 
                $shippingAddress['address1'] ?? 
                $billingAddress['address1'] ?? '';

        $client = Client::where('phone1', $phone)->orWhere('phone2', $phone)->first();

        
        $countryCode = $shippingAddress['country_code'] ?? $billingAddress['country_code'] ?? null;
        $country = Countrie::where('flag', strtolower($countryCode))->first();
        
        if (!$country) {
            Log::error('Country not found: ' . $countryCode);
            
            $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'error',
                'title' => 'Invalid Country Code',
                'message' => "Country code not found: $countryCode in order from {$shopifyStore->store_name}",
                'payload' => json_encode($payload)
            ]);

            $this->triggerPusherNotification($user->id, $notification);
            return response()->json(['error' => 'Invalid country code.'], 400);
        }
    

        if (!$client) {
            Log::info('Creating new client', [
                'name' => $fullName,
                'phone' => $phone,
                'address' => $address
            ]);
            
            $client = new Client();
            $client->id_user = $user->id;
            $client->name = $fullName;
            $client->phone1 = $phone;
            $client->address = $address;
            $client->id_country = $country->id ?? null;
            $client->city = $shippingAddress['city'] ?? $billingAddress['city'] ?? '';
            $client->save();
        }

        $validProducts = [];

        foreach ($order['line_items'] ?? [] as $item) {
            $sku = $item['sku'] ?? '';
            
            if (empty($sku)) {
                Log::warning("Empty SKU in order: $orderId");
                continue;
            }

            $product = Product::where('sku', $sku)->where('id_user', $user->id)->first();
            if (!$product) {
                Log::warning("Product not found: $sku");
                
                $notification = Notification::create([
                    'user_id' => $user->id,
                    'type' => 'error',
                    'title' => 'Product Not Found',
                    'message' => "SKU not found: $sku in order from {$shopifyStore->store_name}",
                    'payload' => json_encode($payload)
                ]);
                
                $this->triggerPusherNotification($user->id, $notification);
                continue;
            }

            $zipValid = Zipcode::where('id_country', $product->id_country)
                ->where('name', $shippingAddress['zip'] ?? '')
                ->exists();

            $validProducts[] = [
                'product' => $product,
                'quantity' => $item['quantity'] ?? 1,
                'zip_valid' => $zipValid,
                'price' => $item['price'] ?? 0
            ];
        }

        if (empty($validProducts)) {
            Log::warning("No valid products found in order: $orderId");
            
            $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'error',
                'title' => 'No valid products in order',
                'message' => "Order ID: $orderId from {$shopifyStore->store_name}",
                'payload' => json_encode($payload)
            ]);

            $this->triggerPusherNotification($user->id, $notification);
            return response()->json(['message' => 'No valid products'], 400);
        }

        $duplicateCheck = Lead::where('client_id', $client->id)
            ->whereDate('created_at', $date->format('Y-m-d'))
            ->where('id_product',$validProducts[0]['product']->id)
            // ->whereHas('products', function($q) use ($validProducts) {
            //     $q->whereIn('id_product', array_column($validProducts, 'product.id'));
            // })
            ->exists();

        if($duplicateCheck) {
            Log::info("Duplicate order found for client: {$client->id}");
            
            $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'info',
                'title' => 'Duplicate Order',
                'message' => "Duplicate order for client ID: {$client->id} from {$shopifyStore->store_name}",
                'payload' => json_encode($payload)
            ]);

            $this->triggerPusherNotification($user->id, $notification);
            //return response()->json(['message' => 'Duplicate order'], 400);
        }

        $paymentMethod = 'COD';
        $isPaidApp = 0;
        $financialStatus = strtolower($order['financial_status'] ?? '');
        
        if ($financialStatus === 'paid' || in_array(strtolower($order['gateway'] ?? ''), ['visa', 'mastercard', 'amex'])) {
            $paymentMethod = 'PREPAID';
            $isPaidApp = 1;
        }

        $lastLead = Lead::orderBy('id', 'desc')->first();
        $leadNumber = substr(strtoupper($user->name), 0, 1) 
                    . substr(strtoupper($user->name), -1)
                    . '-' . str_pad(($lastLead->id ?? 0) + 1, 5, '0', STR_PAD_LEFT);

        $lead = new Lead();
        $lead->n_lead = $leadNumber;
        $lead->id_order = $orderId;
        $lead->id_user = $user->id;
        $lead->client_id = $client->id;
        $lead->id_country = $country->id ?? null;
        $lead->market = "Shopify";
        $lead->id_product = $validProducts[0]['product']->id; 
        $lead->quantity = array_sum(array_column($validProducts, 'quantity'));
        $lead->name = $client->name;
        $lead->email = $client->email;
        $lead->phone = $client->phone1;
        $lead->address = $client->address;
        $lead->city = $client->city;
        $lead->province = $client->province;
        $lead->zipcod = $client->zipcod;
        $lead->lead_value = $order['current_total_price'] ?? 0;
        if($duplicateCheck){
            $lead->status_confirmation = 'duplicated';
        }
        $lead->method_payment = $paymentMethod;
        $lead->ispaidapp = $isPaidApp;
        $lead->created_at = $order['created_at'] ?? $date->format('Y-m-d H:i:s');
        $lead->save();

        foreach ($validProducts as $vp) {
            LeadProduct::create([
                'id_lead' => $lead->id,
                'id_product' => $vp['product']->id,
                'quantity' => $vp['quantity'],
                'lead_value' => $vp['price']
            ]);
        }

        HistoryStatu::create([
            'id_lead' => $lead->id,
            'status' => $lead->status_confirmation,
            'country_id' => $country->id,
            'comment' => "Automatically created from Shopify store: {$shopifyStore->store_name}"
        ]);

        // event(new NewLeadCreated($lead));
        
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => 'success',
            'title' => 'New Shopify Order',
            'message' => "New order received from {$shopifyStore->store_name}",
            'is_read' => false,
            'payload' => json_encode($payload),
        ]);
        
        $this->triggerPusherNotification($user->id, $notification);

        Log::info("Shopify order processed successfully for store {$shopifyStore->id}: $orderId");

        return response()->json(['message' => 'Order processed successfully'], 200);
    }

    private function triggerPusherNotification($userId, $notification)
    {
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = [
            'notification_id' => $notification->id,
            'title' => $notification->title,
            'message' => $notification->message,
            'type' => $notification->type,
            'payload' => json_decode($notification->payload),
            'is_read' => $notification->is_read,
            'time' => $notification->created_at,
        ];

        $pusher->trigger('user.' . $userId, 'Notification', $data);
    }
}