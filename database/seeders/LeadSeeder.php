<?php

namespace Database\Seeders;

use App\Events\LeadCreated;
use App\Events\NewLeadCreated;
use App\Jobs\SendLeadConfirmation;
use App\Listeners\SendWhatsAppMessageListener;
use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\LeadProduct;
use App\Models\HistoryStatu;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use App\Models\Countrie;
use App\Notifications\NewLeadNotification;

class LeadSeeder extends Seeder
{
public function run()
{
    $user = User::first(); 
    $country = Countrie::first(); 
    $client = Client::firstOrCreate([
        'id_user' => $user->id,
        'name' => 'John Doe',
        'phone1' => '+212782315209',
        'address' => '123 Main St',
        'city' => 'New York',
    ]);


    $lead = new Lead();
    $lead->n_lead = 'L-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
    $lead->id_order = 'ORD' . rand(10000, 99999);
    $lead->id_user = $user->id;
    $lead->client_id = $client->id;
    $lead->id_country = $country->id;
    $lead->market = 'Lightfunnels';
    $lead->name = $client->name;
    $lead->phone = $client->phone1;
    $lead->lead_value = 100;
    $lead->method_payment = 'COD';
    $lead->ispaidapp = 0;
    $lead->status_confirmation = 'pending';
    $lead->created_at = now();

    $lead->save();

    $product = Product::first(); 
    $lead->products()->attach($product->id, [
        'quantity' => 2,
        'lead_value' => 75.00,
    ]);

    HistoryStatu::create([
        'id_lead' => $lead->id,
        'status' => 'confirmed',
        'country_id' => $country->id,
        'comment' => 'Automatically created from seeder',
    ]);

    event(new NewLeadCreated($lead));
    // $user->notify(new NewLeadNotification($lead));
    // \Log::info('Lead notification triggered for user: ' . $user->id);


    echo "Lead seeded successfully!";
}
}
