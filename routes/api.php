<?php

use App\Http\Controllers\AIController;
use App\Http\Controllers\TwilioWebhookController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WhatsAppAccountController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Models\LightfunnelStore;
use App\Models\LightfunnelWebhook;
use App\Models\YoucanAccount;
use App\Models\YoucanStore;
use App\Models\YoucanWebhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product','ProductController@api')->name('index');

Route::post('/twilio/webhook', [TwilioWebhookController::class, 'handleResponse'])->middleware('set.locale');
Route::post('/ai/query', [AIController::class, 'handleQuery']);
Route::post('/whatsapp/webhook', [WhatsAppWebhookController::class, 'handleIncoming']);
Route::post('/whatsapp-numbers/webhook/{token}', [WhatsAppAccountController::class, 'webhook'])
->name('whatsapp-numbers.webhook'); 
Route::post('webhooks/woocommerce/order-created', [WebhookController::class, 'WooCommerceOrderCreated'])
    ->name('webhooks.woocommerce.order_created');
Route::post('webhooks/woocommerce/order-created', [WebhookController::class, 'WooCommerceOrderCreated'])
    ->name('webhooks.woocommerce.order_created');

Route::post('/registerLighftunnelsData', function (Request $request) {
        $validated = $request->validate([
            'account_id' => 'required|string',
            'access_token' => 'required|string',
            'domaine_url' => 'required|url',
            'token' => 'nullable|string',
            'webhook_url' => 'required|url',
            'user_id' => 'required|integer',
        ]);

        
        $store = LightfunnelStore::updateOrCreate(
            ['account_id' => $validated['account_id']],
            [
                'access_token' => $validated['access_token'],
                'domaine_url' => $validated['domaine_url'],
                'refresh_token' => $validated['token'],
                'user_id' => $validated['user_id'],
            ]
        );

    LightfunnelWebhook::create([
        'lightfunnel_store_id' => $store->id,
        'url' => $validated['webhook_url'],
        'webhook_event' => "order/created",
    ]);

    return response()->json(['success' => true, 'store' => $store]);
});

Route::post('/registerYouCanData', function (Request $request) {
    $validated = $request->validate([
        'store_id' => 'required|string',
        'account_slug' => 'required|string',
        'account_is_active' => 'required|boolean',
        'account_is_verified' => 'required|boolean',
        'user_id' => 'required|integer',
        'access_token' => 'required|string',
        'domain_url' => 'required|url',
        'refresh_token' => 'nullable|string',
        'webhook_url' => 'required|url',
        'webhook_id' => 'required|string',
        'account_email' => 'required|email',
    ]);

    $account = YoucanAccount::updateOrCreate(
        ['email' => $validated['account_email'], 'user_id' => $validated['user_id']], 
        [
            'user_id' => $validated['user_id'],
            'email' => $validated['account_email'],
        ]
    );

    $store = YoucanStore::updateOrCreate(
        ['store_id' => $validated['store_id']],
        [
            'account_id' => $account->id,
            'slug' => $validated['account_slug'],
            'is_active' => $validated['account_is_active'],
            'is_email_verified' => $validated['account_is_verified'],
            'access_token' => $validated['access_token'],
        ]
    );

    YoucanWebhook::updateOrCreate(
        ['store_id' => $store->id],
        [
            'webhook_id' => $validated['webhook_id'],
            'target_url' => $validated['webhook_url'],
            'event' => 'order.create',
        ]
    );

    return response()->json(['success' => true, 'store' => $store]);
});