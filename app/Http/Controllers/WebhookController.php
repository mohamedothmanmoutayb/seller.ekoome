<?php

namespace App\Http\Controllers;

use App\Events\LeadCreated;
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
use App\Models\WooCommerceIntegration;
use App\Models\Zipcode;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use Pusher\Pusher;
use App\Events\NewNotification;


class WebhookController extends Controller
{

    //    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    lightfunnels  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    public function OrderCreated(Request $request,$accountId)
    {
        $payload = json_decode($request->getContent(), true);
        $payload['source'] = 'lightfunnels'; 
        $date = new DateTime();
        Log::info("Lightfunnels Order Created : " . json_encode($payload));
        if (!isset($payload['node'])) {
            Log::warning("Invalid payload structure: 'node' key missing");

            return $this->OrderCreatedYoucan($request);
            // return response()->json(['message' => 'Invalid payload structure'], 400);
        }
    
        $order = $payload['node'];
    
        $orderId = $order['id'] ?? null;
        $accountId = $order['account_id'] ?? null;
        $orderTotal = $order['total'] ?? 0;
        $orderCreatedAt = $order['created_at'] ?? $date->format('Y-m-d H:i:s');
    
        $account = LightfunnelStore::where('account_id', $accountId)->first();
        if (!$account) {
            Log::error("Account not found: $accountId");
        
            return response()->json(['message' => 'Account not found'], 404);
        }

        $user = User::find($account->user_id);
        $payload['playSound'] = optional($user->notificationSetting)->sound ?? true;
        if (!$user) {
            Log::error("User not found for account: $accountId");
            return response()->json(['message' => 'User not found'], 404);
        }
    
        if (Lead::where('id_order', $orderId)->where('id_user', $user->id)->exists()) {
            Log::info("Order already exists: $orderId");
                //  $settings = $user->notificationSetting;

                // if ($settings) {
                //      $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

                //     if (empty($titles) || !in_array('warning', $titles)) {
                //          return response()->json(['message' => 'Order already processed'], 200); 
                //     }

                // }

            $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'warning',
                'title' => 'Order already processed',
                'message' => "Order ID: $orderId",
                'payload' => json_encode($payload)
            ]);

             if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }
            return response()->json(['message' => 'Order already processed'], 200);
        }

        $customer = $order['customer'] ?? [];
        $shippingAddress = $order['shipping_address'] ?? [];
        $phone = $shippingAddress['phone'] ?? $customer['phone'] ?? null;
    
        $client = Client::where('phone1', $phone)->first();
        $country = Countrie::where('flag', strtolower($shippingAddress['country']))->first();


        if (!$country) {
            Log::error('Country not found: ' . $country);

            //  $settings = $user->notificationSetting;

            //     if ($settings) {
            //          $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

            //         if (empty($titles) || !in_array('error', $titles)) {
            //              return ; 
            //         }

            //     }

            $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'error',
                'title' => 'Invalid Country Code',
                'message' => "Country code not found: " . $shippingAddress['country'],
                'payload' => json_encode($payload)
            ]);

            if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }
            return response()->json(['error' => 'Invalid country code.'], 400);
        }


        if (!$client) {
            $client = new Client();
            $client->id_user = $user->id;
            $client->name = $shippingAddress['first_name'] . ' ' . $shippingAddress['last_name'];
            $client->phone1 = $phone;
            $client->address = $shippingAddress['line1'] ?? '';
            $client->id_country = $country->id ?? null;
            $client->city = $shippingAddress['city'] ?? '';
            $client->save();
        }
    
        $validProducts = [];
        foreach ($order['items'] ?? [] as $item) {
            $skuString = $item['sku'] ?? '';
            $skus = explode(';', $skuString);
    
                    foreach ($skus as $skuEntry) {
                        $parts = explode(':', $skuEntry);
                        $sku = trim($parts[0]);
                        $quantity = $parts[1] ?? 1;
            
                        $product = Product::where('sku', $sku)->where('id_user', $user->id)->first();
                        if (!$product) {
                        Log::warning("Product not found: $sku");
                       
                        //   $settings = $user->notificationSetting;

                // if ($settings) {
                //      $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

                //     if (empty($titles) || !in_array('error', $titles)) {
                //          return ; 
                //     }

                // }
                        $notification =  Notification::create([
                                    'user_id' => $user->id,
                                    'type' => 'error',
                                    'title' => 'Product Not Found',
                                    'message' => "SKU not found: $sku",
                                    'payload' => json_encode($payload)
                                ]);
                            if ($user) {
                    $this->triggerPusherNotification($user->id, $notification);
                }
       
          continue;
        }

                $zipValid = Zipcode::where('id_country', $product->id_country)
                    ->where('name', $shippingAddress['zip'])
                    ->exists();
    
                $validProducts[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'zip_valid' => $zipValid,
                    'price' => $item['price'] ?? 0
                ];
            }
    }
    
        if (empty($validProducts)) {
            Log::warning("No valid products found in order: $orderId");

            // $settings = $user->notificationSetting;

            //     if ($settings) {
            //          $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

            //         if (empty($titles) || !in_array('error', $titles)) {
            //              return response()->json(['message' => 'No valid products'], 400); 
            //         }

            //     }
             $notification = Notification::create([
                'user_id' => $user->id ?? null,
                'type' => 'error',
                'title' => 'No valid products in order',
                'message' => "Order ID: $orderId",
                'payload' => json_encode($payload)
            ]);

            if ($user) {
             $this->triggerPusherNotification($user->id, $notification);
        }
   
            return response()->json(['message' => 'No valid products'], 400);
        }
    
        $duplicateCheck = Lead::where('client_id', $client->id)
            ->whereDate('created_at', $date->format('Y-m-d'))
            ->whereHas('product', function($q) use ($validProducts) {
                $q->whereIn('id_product', array_column($validProducts, 'product.id'));
            })
            ->exists();

        if($duplicateCheck) {
            Log::info("Duplicate order found for client: {$client->id}");
            // $settings = $user->notificationSetting;

            //     if ($settings) {
            //          $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

            //         if (empty($titles) || !in_array('info', $titles)) {
            //              return response()->json(['message' => 'Duplicate order'], 400); 
            //         }

            //     }
               Notification::create([
                    'user_id' => $user->id,
                    'type' => 'info',
                    'title' => 'Duplicate Order',
                    'message' => "Duplicate order for client ID: {$client->id}",
                    'payload' => json_encode($payload)
                ]);

                 if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }
   
            return response()->json(['message' => 'Duplicate order'], 400);
        }
    
        $paymentMethod = 'COD';
        $isPaidApp = 0;
        if (!empty($order['payments'])) {
            $payment = $order['payments'][0];
            if (strpos(strtoupper($payment['source']['payment_gateway']['prototype']['key']), 'PREPAID') !== false) {
                $paymentMethod = 'PREPAID';
                $isPaidApp = 1;
            }
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
        $lead->id_country  = $country->id ?? null;
        $lead->market = "Lightfunnels";
        if (!empty($validProducts)) {
            $lead->id_product = $validProducts[0]['product']->id;
        }
        $totalQuantity = 0;
        foreach ($validProducts as $vp) {
            $totalQuantity += $vp['quantity'];
        }
        $lead->quantity = $totalQuantity;
        $lead->name = $client->name;
        $lead->email = $client->email;
        $lead->phone = $client->phone1;
        $lead->address = $client->address;
        $lead->city = $client->city;
        $lead->province = $client->province;
        $lead->zipcod = $client->zipcod;
        $lead->lead_value = $orderTotal;
        $lead->method_payment = $paymentMethod;
        $lead->ispaidapp = $isPaidApp;
        // $lead->status_confirmation = 'new order';
        $lead->created_at = $orderCreatedAt;
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
            'comment' => 'Automatically created from lightfunnels webhook'
        ]);

        event(new NewLeadCreated($lead));
        // event(new LeadCreated($lead, $user->id));

        // $settings = $user->notificationSetting;

        // if ($settings) {
        //     $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

        //     if (empty($titles) || !in_array('success', $titles)) {
        //         return response()->json(['message' => 'Order processed successfully'], 200); 
        //     }
        // }

        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => 'success',
            'title' => 'Order received',
            'message' => "Order processed successfully.",
            'is_read' => false,
            'payload' => json_encode($payload),
        ]);
        
        
        if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }
   

        Log::info("Order processed successfully: $orderId");

        return response()->json(['message' => 'Order processed successfully'], 200);
    
    }


   
//    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    Youcan  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


    
    // public function OrderCreatedYoucan(Request $request)
    // {
    //      $payload = json_decode($request->getContent(), true);
    //      $payload['source'] = 'youcan'; 

    //     Log::info("YouCan Order Created : " . json_encode($payload));
    //     $date = new DateTime();
        
        
    //     $orderId = $payload['id'] ?? null;
    //     $orderRef = $payload['ref'] ?? null;
    //     $orderTotal = $payload['total'] ?? 0;
    //     $orderCreatedAt = $payload['created_at'] ?? $date->format('Y-m-d H:i:s');
    //     $currency = $payload['currency'] ?? null;
        
    //     $storeId = $payload['store_id'] ?? null;
    //     $store = YoucanStore::where('store_id', $storeId)->first();
    //     if (!$store) {
    //         Log::error("YouCan store not found: $storeId");
          
    //                 return response()->json(['message' => 'Store not found'], 404);
    //             }

    //     $account = $store->account;
    //     if (!$account) {
    //         Log::error("YouCan account not found for store: $storeId");
         
    //         return response()->json(['message' => 'Account not found'], 404);
    //     }

    //     $user = $account->user;
        
    //     if (!$user) {
    //         Log::error("User not found for YouCan account: " . $account->id);
    //         return response()->json(['message' => 'User account not properly linked'], 404);
    //     }

    //     if (Lead::where('id_order', $orderId)->where('id_user', $user->id)->exists()) {
    //         Log::info("YouCan order already exists: $orderId");

    //             // $settings = $user->notificationSetting;
    //             // if ($settings) {
    //             //      $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

    //             //     if (empty($titles) || !in_array('warning', $titles)) {
    //             //          return response()->json(['message' => 'Order already processed'], 200); 
    //             //     }
    //             // }

    //               $notification = Notification::create([
    //             'user_id' => $user->id,
    //             'type' => 'warning',
    //             'title' => 'Order already processed',
    //             'message' => "Order ID: $orderId",
    //             'payload' => json_encode($payload)
    //         ]);

    //          if ($user) {
    //         $this->triggerPusherNotification($user->id, $notification);
    //     }
    //         return response()->json(['message' => 'Order already processed'], 200);
    //     }

    //     $customer = $payload['customer'] ?? [];
    //     $shipping = $payload['shipping'] ?? [];
    //     $phone = $customer['phone'] ?? null;
    //     $firstName = $customer['first_name'] ?? '';
    //     $lastName = $customer['last_name'] ?? '';
    //     $fullName = $customer['full_name'] ?? ($firstName . ' ' . $lastName);

    //     $client = Client::where('phone1', $phone)->first();

    //     if (!$client) {
    //         $client = new Client();
    //         $client->id_user = $user->id;
    //         $client->name = $fullName;
    //         $client->phone1 = $phone;
    //         $client->address = $shipping['address']['line1'] ?? '';
    //         $client->city = $shipping['address']['city'] ?? '';
    //         $client->save();
    //     }

    //     $validProducts = [];
    //     foreach ($payload['variants'] ?? [] as $item) {
    //         Log::info("Processing item: " . json_encode($item));
    //         $variant = $item['variant'] ?? [];
    //         $productData = $variant['product'] ?? [];
            
    //         $skuString = $variant['sku'] ?? null;
    //         $defaultQuantity = $item['quantity'] ?? 1;

    //         if (!$skuString) {
    //             Log::warning("Product SKU missing in YouCan order item");

    //             // $settings = $user->notificationSetting;

    //             // if ($settings) {
    //             //         $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;  
    //             //     if (empty($titles) || !in_array('warning', $titles)) {
    //             //          return ;
    //             //     }
    //             // }

    //                    $notification =  Notification::create([
    //                         'user_id' => $user->id,
    //                         'type' => 'warning',
    //                         'title' => 'Product Not Found',
    //                         'message' => "SKU not found: $skuString",
    //                         'payload' => json_encode($payload)
    //                     ]);
    //                  if ($user) {
    //         $this->triggerPusherNotification($user->id, $notification);
    //     }
       
    //             continue;
    //         }

    //         $skuEntries = explode(';', $skuString);
            
    //         foreach ($skuEntries as $skuEntry) {
    //             $parts = explode(':', $skuEntry);
    //             $sku = trim($parts[0]);
    //             $quantity = isset($parts[1]) ? (int)$parts[1] : $defaultQuantity;
                
    //             $product = Product::where('sku', $sku)->where('id_user', $user->id)->first();
    //             if (!$product) {
    //                 Log::warning("Product not found: $sku");
    //                 continue;
    //             }

    //             $zipValid = true;
    //             if (isset($shipping['address']['zip'])) {
    //                 $zipValid = Zipcode::where('id_country', $product->id_country)
    //                     ->where('name', $shipping['address']['zip'])
    //                     ->exists();
    //             }


    //             $validProducts[] = [
    //                 'product' => $product,
    //                 'quantity' => $quantity,
    //                 'zip_valid' => $zipValid,
    //                 'price' => $item['price'] ?? 0
    //             ];

    //             Log::info("Valid product added: " . json_encode($validProducts));
    //         }
    //     }

    //     if (empty($validProducts)) {
    //         Log::warning("No valid products found in YouCan order: $orderId");

    //         // $settings = $user->notificationSetting;

    //         //     if ($settings) {
    //         //          $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

    //         //         if (empty($titles) || !in_array('warning', $titles)) {
    //         //              return response()->json(['message' => 'No valid products'], 400); 
    //         //         }

    //         //     }
            
    //       $notification = Notification::create([
    //             'user_id' => $user->id ?? null,
    //             'type' => 'warning',
    //             'title' => 'No valid products in order',
    //             'message' => "Order ID: $orderId",
    //             'payload' => json_encode($payload)
    //         ]);

    //         Log::info('About to dispatch event');
    //         event(new NewNotification($notification, $user->id));
        
            
    //         return response()->json(['message' => 'No valid products'], 400);
    //     }

    //     $duplicateCheck = Lead::where('client_id', $client->id)
    //         ->whereDate('created_at', $date->format('Y-m-d'))
    //         ->whereHas('product', function($q) use ($validProducts) {
    //             $q->whereIn('id_product', array_column($validProducts, 'product.id'));
    //         })
    //         ->exists();

    //     if($duplicateCheck) {
    //         Log::info("Duplicate order found for client: {$client->id}");

    //         // $settings = $user->notificationSetting;

    //             // if ($settings) {
    //             //      $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

    //             //     if (empty($titles) || !in_array('warning', $titles)) {
    //             //          return response()->json(['message' => 'Duplicate order'], 400); 
    //             //     }

    //             // }
    //         $notification = Notification::create([
    //             'user_id' => $user->id,
    //             'type' => 'warning',
    //             'title' => 'Duplicate Order',
    //             'message' => "Duplicate order for client ID: {$client->id}",
    //             'payload' => json_encode($payload)
    //         ]);

    //          if ($user) {
    //         $this->triggerPusherNotification($user->id, $notification);
    //     }
    //         return response()->json(['message' => 'Duplicate order'], 400);
    //     }
    

    //     $paymentMethod = 'COD';
    //     $isPaidApp = 0;
    //     $payment = $payload['payment'] ?? [];
    //     if (isset($payment['payload']['gateway'])) {
    //         $gateway = strtoupper($payment['payload']['gateway']);
    //         if ($gateway !== 'COD') {
    //             $paymentMethod = 'PREPAID';
    //             $isPaidApp = 1;
    //         }
    //     }

    //     $lastLead = Lead::orderBy('id', 'desc')->first();
    //     $leadNumber = substr(strtoupper($user->name), 0, 1) 
    //                 . substr(strtoupper($user->name), -1)
    //                 . '-' . str_pad(($lastLead->id ?? 0) + 1, 5, '0', STR_PAD_LEFT);


    //     $lead = new Lead();
    //     $lead->n_lead = $leadNumber;
    //     $lead->id_order = $orderId;
    //     $lead->id_user = $user->id;
    //     $lead->client_id = $client->id;
    //     $lead->market = "YouCan";
    //     if (!empty($validProducts)) {
    //         $lead->id_product = $validProducts[0]['product']->id;
    //         $lead->id_country = $validProducts[0]['product']->id_country;
    //     }
        
    //     $totalQuantity = 0;
    //     foreach ($validProducts as $vp) {
    //         $totalQuantity += $vp['quantity'];
    //     }

        
    //     $lead->quantity = $totalQuantity;
    //     $lead->name = $client->name;
    //     $lead->email = $client->email;
    //     $lead->phone = $client->phone1;
    //     $lead->address = $client->address;
    //     $lead->city = $client->city;
    //     $lead->province = $client->province;
    //     $lead->zipcod = $client->zipcod;
    //     $lead->lead_value = $orderTotal;
    //     $lead->method_payment = $paymentMethod;
    //     $lead->ispaidapp = $isPaidApp;
    //     $lead->created_at = $orderCreatedAt;
    //     $lead->currency = $currency;
    //     $lead->save();

    //     foreach ($validProducts as $vp) {
    //         LeadProduct::create([
    //             'id_lead' => $lead->id,
    //             'id_product' => $vp['product']->id,
    //             'quantity' => $vp['quantity'],
    //             'lead_value' => $vp['price']
    //         ]);
    //     }

    //     HistoryStatu::create([
    //         'id_lead' => $lead->id,
    //         'status' => $lead->status_confirmation,
    //         'comment' => 'Automatically created from YouCan webhook'
    //     ]);

    //     // event(new NewLeadCreated($lead));
    //     // event(new LeadCreated($lead, $user->id));

    //     // $settings = $user->notificationSetting;
    //     // if ($settings) {
    //     //     $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

    //     //     if (empty($titles) || !in_array('success', $titles)) {
    //     //         return response()->json(['message' => 'Order processed successfully'], 200); 
    //     //     }
    //     // }

    //     $notification = Notification::create([
    //         'user_id' => $user->id,
    //         'type' => 'success',
    //         'title' => 'Order received',
    //         'message' => "Order processed successfully.",
    //         'is_read' => false,
    //         'payload' => json_encode($payload),
    //     ]);
        
        
    //     if ($user) {
    //         $this->triggerPusherNotification($user->id, $notification);
    //     }
   

    //     Log::info("YouCan order processed successfully: $orderId");

    //     return response()->json(['message' => 'Order processed successfully'], 200);
    // }
 
    
//    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$    Woo commmerce   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


    public function WooCommerceOrderCreated(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $payload['source'] = 'wooCommerce'; 
      
        $date = new DateTime();

        Log::info("WooCommerce Order Created : " . json_encode($payload));
        
        $shopDomain = $request->header('x-wc-webhook-source');
        if (!$shopDomain) {
            Log::error("Missing WooCommerce store domain in webhook headers");
            return response()->json(['message' => 'Missing store domain'], 400);
        }

        $parsedDomain = parse_url($shopDomain, PHP_URL_HOST);
        if (!$parsedDomain) {
            Log::error("Invalid WooCommerce store domain format: $shopDomain");
            return response()->json(['message' => 'Invalid store domain format'], 400);
        }

        $store = WooCommerceIntegration::where('domain', 'like', '%'.$parsedDomain.'%')->first();
        if (!$store) {
            Log::error("WooCommerce store not found in database: $parsedDomain");
            return response()->json(['message' => 'Store not registered'], 404);
        }

        $user = $store->user;
        if (!$user) {
            Log::error("Account not found for WooCommerce store: $parsedDomain");
            return response()->json(['message' => 'Account not found'], 404);
        }

        $orderId = $payload['id'] ?? null;
        $orderRef = $payload['number'] ?? null;
        $orderTotal = $payload['total'] ?? 0;
        $orderCreatedAt = $payload['date_created'] ?? $date->format('Y-m-d H:i:s');
        $currency = $payload['currency'] ?? null;
        
        if (Lead::where('id_order', $orderId)->where('id_user', $user->id)->exists()) {
            
            Log::info("WooCommerce order already exists: $orderId");

            // $settings = $user->notificationSetting;
            // if ($settings) {
            //     $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;
            //     if (empty($titles) || !in_array('warning', $titles)) {
            //         return response()->json(['message' => 'Order already processed'], 200); 
            //     }
            // }

             $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'warning',
                'title' => 'Order already processed',
                'message' => "Order ID: $orderId",
                'payload' => json_encode($payload)
            ]);

             if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }
            return response()->json(['message' => 'Order already processed'], 200);
        }

        $billing = $payload['billing'] ?? [];
        $shipping = $payload['shipping'] ?? [];
        $phone = $billing['phone'] ?? null;
        $firstName = $billing['first_name'] ?? '';
        $lastName = $billing['last_name'] ?? '';
        $fullName = trim("$firstName $lastName");
        $email = $billing['email'] ?? '';
        
        $client = Client::where('phone1', $phone)->where('id_user', $user->id)->first();

        if (!$client) {
            $client = new Client();
            $client->id_user = $user->id;
            $client->name = $fullName;
            $client->phone1 = $phone;
            $client->address = $shipping['address_1'] ?? ($billing['address_1'] ?? '');
            $client->city = $shipping['city'] ?? ($billing['city'] ?? '');
            $client->save();
        }

        $validProducts = [];
        foreach ($payload['line_items'] ?? [] as $item) {
            $sku = $item['sku'] ?? null;
            $quantity = $item['quantity'] ?? 1;
            
            if (!$sku) {
                Log::warning("Product SKU missing in WooCommerce order item");

                // $settings = $user->notificationSetting;
                // if ($settings) {
                //     $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;
                //     if (empty($titles) || !in_array('warning', $titles)) {
                //         return response()->json(['message' => 'Product SKU missing'], 400); 
                //     }
                // }
                   Log::warning("Product SKU missing in YouCan order item");
                       $notification =  Notification::create([
                            'user_id' => $user->id,
                            'type' => 'warning',
                            'title' => 'Product Not Found',
                            'message' => "SKU not found: $sku",
                            'payload' => json_encode($payload)
                        ]);
                     if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }
                continue;
            }

            $product = Product::where('sku', $sku)->where('id_user', $user->id)->first();
            if (!$product) {
                Log::warning("Product not found: $sku");
                continue;
            }

            $zipValid = true;
            $postcode = $shipping['postcode'] ?? ($billing['postcode'] ?? '');
            if ($postcode && $product->id_country) {
                $zipValid = Zipcode::where('id_country', $product->id_country)
                    ->where('name', $postcode)
                    ->exists();
            }

            $validProducts[] = [
                'product' => $product,
                'quantity' => $quantity,
                'zip_valid' => $zipValid,
                'price' => $item['price'] ?? 0
            ];
        }

        if (empty($validProducts)) {
            Log::warning("No valid products found in WooCommerce order: $orderId");
            // $settings = $user->notificationSetting;

            //     if ($settings) {
            //          $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

            //         if (empty($titles) || !in_array('warning', $titles)) {
            //              return response()->json(['message' => 'No valid products'], 400); 
            //         }

            //     }
              $notification = Notification::create([
                'user_id' => $user->id ?? null,
                'type' => 'warning',
                'title' => 'No valid products in order',
                'message' => "Order ID: $orderId",
                'payload' => json_encode($payload)
            ]);

             if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }
          
            return response()->json(['message' => 'No valid products'], 400);
        }

        $duplicateCheck = Lead::where('client_id', $client->id)
            ->whereDate('created_at', $date->format('Y-m-d'))
            ->whereHas('product', function($q) use ($validProducts) {
                $q->whereIn('id_product', array_column($validProducts, 'product.id'));
            })
            ->exists();

        if($duplicateCheck) {
            Log::info("Duplicate order found for client: {$client->id}");
            // $settings = $user->notificationSetting;
            // if ($settings) {
            //     $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;
            //     if (empty($titles) || !in_array('warning', $titles)) {
            //         return response()->json(['message' => 'Duplicate order'], 400);
            //     }
            // }

                $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'warning',
                'title' => 'Duplicate Order',
                'message' => "Duplicate order for client ID: {$client->id}",
                'payload' => json_encode($payload)
            ]);

             if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }           
            
            Log::info("Duplicate order found for client: {$client->id}");
            return response()->json(['message' => 'Duplicate order'], 400);
        }

        $paymentMethod = strtoupper($payload['payment_method'] ?? 'cod') === 'COD' ? 'COD' : 'PREPAID';
        $isPaidApp = $paymentMethod === 'PREPAID' ? 1 : 0;

        $lastLead = Lead::orderBy('id', 'desc')->first();
        $leadNumber = substr(strtoupper($user->name), 0, 1) 
                    . substr(strtoupper($user->name), -1)
                    . '-' . str_pad(($lastLead->id ?? 0) + 1, 5, '0', STR_PAD_LEFT);

        $lead = new Lead();
        $lead->n_lead = $leadNumber;
        $lead->id_order = $orderId;
        $lead->id_user = $user->id;
        $lead->client_id = $client->id;
        $lead->market = "WooCommerce";
        $lead->id_product = $validProducts[0]['product']->id;
        $lead->id_country = $validProducts[0]['product']->id_country;
        
        $totalQuantity = array_sum(array_column($validProducts, 'quantity'));

        $lead->quantity = $totalQuantity;
        $lead->name = $client->name;
        $lead->email = $client->email;
        $lead->phone = $client->phone1;
        $lead->address = $client->address;
        $lead->city = $client->city;
        $lead->province = $client->province;
        $lead->zipcod = $client->zipcod;
        $lead->lead_value = $orderTotal;
        $lead->method_payment = $paymentMethod;
        $lead->ispaidapp = $isPaidApp;
        $lead->created_at = $orderCreatedAt;
        $lead->currency = $currency;
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
            'comment' => 'Automatically created from WooCommerce webhook'
        ]);

        // event(new NewLeadCreated($lead));
        // event(new LeadCreated($lead, $user->id));

        // $settings = $user->notificationSetting;
        // if ($settings) {
        //     $titles = is_string($settings->titles) ? json_decode($settings->titles, true) : $settings->titles;

        //     if (empty($titles) || !in_array('success', $titles)) {
        //         return response()->json(['message' => 'Order processed successfully'], 200); 
        //     }
        // }

         $notification = Notification::create([
            'user_id' => $user->id,
            'type' => 'success',
            'title' => 'Order received',
            'message' => "Order processed successfully.",
            'is_read' => false,
            'payload' => json_encode($payload),
        ]);
        
        
        if ($user) {
            $this->triggerPusherNotification($user->id, $notification);
        }

        Log::info("WooCommerce order processed successfully. Order ID: $orderId, Lead ID: {$lead->id}");

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