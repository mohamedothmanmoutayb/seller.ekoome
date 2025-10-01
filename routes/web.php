<?php

use App\Http\Controllers\AgentStatusController;
use App\Http\Controllers\AgentWhatsappController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\ConfirmationTemplateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LightfunnelsController;
use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\TwilioWebhookController;
use App\Http\Controllers\WhatsAppAccountController;
use App\Http\Controllers\WhatsappAnalyticsController;
use App\Http\Controllers\AmeexWebhookController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\WooCommerceIntegrationController;
use App\Http\Controllers\YouCanController;
use App\Http\Services\TwilioService;
use App\Models\Lead;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationOffersController;
use App\Http\Controllers\OlivraisonWebhookController;
use App\Http\Controllers\UltraMessageAccountController;
use App\Http\Controllers\WhatsappUIController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConfirmationNotificationTemplateController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\WhatsAppBusinessAccountController;
use App\Http\Controllers\WhatsAppMessageController;
use App\Http\Controllers\WhatsAppNumberController;
use App\Http\Controllers\WhatsAppTemplateController;
use App\Models\WhatsappBusinessAccount;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WhatsAppDashboardController;
use App\Models\User;
use App\Http\Controllers\AiAgentController;
use App\Http\Controllers\PlanReceiverController;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::get('/test-notification', function () {
    $user = User::find(1); // adjust to a real user ID

    $notification = \App\Models\Notification::create([
        'user_id' => $user->id,
        'type' => 'warning',
        'title' => 'Test Notification',
        'message' => "Testing from route",
        'payload' => json_encode(['test' => true])
    ]);

    event(new \App\Events\NewNotification($notification, $user->id));

    return response()->noContent(); 
});


Route::get('/aiagent', [AiAgentController::class, 'index'])->name('aiagents.index');
Route::get('/aiagent/{id}/show', [AiAgentController::class, 'show'])->name('aiagents.show');
Route::post('/aiagent/aiagents', [AiAgentController::class, 'store'])->name('aiagents.store');
Route::get('/aiagent/{id}/edit', [AiAgentController::class, 'edit'])->name('aiagents.edit');
Route::put('/aiagent/{id}', [AiAgentController::class, 'update'])->name('aiagents.update');
Route::delete('/aiagent/{id}', [AiAgentController::class, 'destroy'])->name('aiagents.destroy');
Route::post('/aiagent/addKnowledge', [AiAgentController::class, 'addKnowledge'])->name('ai-agent.addKnowledge');
Route::get('/aiagents/knowledge/{id}', [AiAgentController::class, 'getKnowledgeEntry']);
Route::post('/aiagents/knowledge/{id}', [AiAgentController::class, 'updateKnowledgeEntry']);
Route::delete('/aiagent/knowledge/{id}', [AiAgentController::class, 'destroyentries'])->name('aiagent.knowledge.destroy');
Route::post('/ai-agent/{id}/save-enabled-actions', [AiAgentController::class, 'saveEnabledActions']);
Route::get('/aiagents/list', [AiAgentController::class, 'list'])->name('aiagents.list');



Route::post('/subscription', [SubscriptionController::class, 'store']);
Route::get('/subscription/check/{subscriberId}', [SubscriptionController::class, 'checkSubscription']);
Route::post('/plans', [PlanReceiverController::class, 'receivePlans'])
    ->name('api.plans.receive');
Route::get('/plans/available', [PlanReceiverController::class, 'getAvailablePlans'])->name('plans.available');

Route::get('/usage/metrics', [UsageController::class, 'getUsageMetrics'])->name('usage.metrics');
Route::post('/usage/increment/{metric}', [UsageController::class, 'incrementUsage'])->name('usage.increment');
Route::get('/usage/limits/check', [UsageController::class, 'checkLimits'])->name('usage.limits.check');



Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::get('/notifications', 'NotificationController@index')->name('notifications.index')->middleware('auth');
Route::get('/notifications/filter', [NotificationController::class, 'filter'])->name('notifications.filter');
Route::get('/notifications/list', [NotificationController::class, 'list'])->name('notifications.list');
Route::get('/notifications/delete/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
Route::get('/notifications/delete-all', [NotificationController::class, 'deleteAll']);
Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
Route::post('/notifications/settings', [NotificationController::class, 'storePreferences'])->name('notifications.settings')->middleware('auth');
Route::get('/notifications/settingsget', [NotificationController::class, 'getPreferences'])->name('notifications.get');



Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auth/redirect','HomeController@auth')->name('auth');
Route::get('/callback','HomeController@youcanAuth')->name('auth');
Route::get('/forget-password', 'ForgotPasswordController@getEmail');
Route::post('/forget-password', 'ForgotPasswordController@postEmail');
Route::get('/{token}/reset-password', 'ResetPasswordController@getPassword');
Route::post('/reset-password', 'ResetPasswordController@updatePassword');
Route::any('/webhook','HomeController@webhook')->name('webhook');
Route::get('/register', 'HomeController@index')->name('home');
Auth::routes();

Route::post('/webhook/ameex', [AmeexWebhookController::class, 'handle']);
Route::post('/webhook/olivraison', [OlivraisonWebhookController::class, 'handle']);
Route::get('/analytics','AnalyticsController@index')->name('analytics');

Route::prefix('analytics')->name('analytics.')->group(function () {
    Route::get('/netprofite', [AnalyticsController::class, 'netprofite'])->name('netprofite');
    Route::get('/confirmation', [AnalyticsController::class, 'confirmation'])->name('confirmation');
    Route::get('/shipping', [AnalyticsController::class, 'shipping'])->name('shipping');
});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/countries/{id}','HomeController@countries')->name('countries');
Route::get('city/{id}','HomeController@cities')->name('cities');
Route::get('zone/{id}','HomeController@zones')->name('zones');
Route::get('products/{id}','HomeController@products')->name('products');
Route::post('processed','HomeController@processed')->name('processed');
Route::post('totalorder','HomeController@totalorder')->name('totalorder');
Route::post('countproduct','HomeController@countproduct')->name('countproduct');
Route::get('totalrevenue','HomeController@totalrevenue')->name('totalrevenue');
Route::get('profitSeller','HomeController@profitSeller')->name('profitseller');
Route::get('ordersDiffrence','HomeController@ordersDiffrence')->name('ordersdiffrence');
Route::get('earnings','HomeController@earning')->name('earnings');
Route::get('confirmation','HomeController@confirmation')->name('confirmation');
Route::get('shipping','HomeController@shipping')->name('shipping');
Route::post('datachartorder','HomeController@datachartorder')->name('datachartorder');
Route::post('datachartlivraison','HomeController@datachartlivraison')->name('datachartlivraison');
Route::get('home','HomeController@index')->name('datacharttopproduct');

Route::group(['prefix'=>'stores','as'=>'stores.', 'middleware'=>['auth']], function(){
    Route::get('/', 'StoreController@index')->name('index');
    Route::get('/create', 'StoreController@create')->name('create');
    Route::post('/store', 'StoreController@store')->name('store')->middleware('plan.limits:stores');
    Route::get('/{id}/edit', 'StoreController@edit')->name('edit');
    Route::post('/update', 'StoreController@update')->name('update');
    Route::get('/delete/{id}', 'StoreController@destroy')->name('delete');
    Route::get('/products/{id}', 'StoreController@products')->name('products');
    //Route::delete('/multidelete', 'CitieController@multidelete')->name('multidelete');
});

Route::group(['prefix'=>'products','as'=>'products.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('/create', 'ProductController@create')->name('create');
    Route::get('/show/{id}', 'ProductController@show')->name('show');
    Route::post('/store', 'ProductController@store')->name('store')->middleware('plan.limits:products');
    Route::get('/{id}/edit/', 'ProductController@edit')->name('edit');
    Route::post('/update', 'ProductController@update')->name('update');
    Route::post('/delete', 'ProductController@destroy')->name('delete');
    Route::get('imports/{id}','ProductController@imports')->name('imports');
    Route::get('warehouses/{id}','ProductController@stocks')->name('stocks');
    Route::post('warehouses/store','ProductController@warehousestore')->name('warehousestore');
    Route::get('warehousesstock/{id}','ProductController@warehousesstock')->name('warehousesstock');
    Route::get('stockedit/{id}','ProductController@stockedit')->name('stockedit');
    Route::post('stockupdate/{id}','ProductController@stockupdate')->name('stockupdate');
    Route::post('statusconf/{id}','ProductController@statusconf')->name('statusconf');
    Route::get('stockdelete/{id}','ProductController@stockdelete')->name('stockdelete');
    Route::post('/upsel','ProductController@upsel')->name('upsel');
    Route::get('/upsells/{id}','ProductController@upsells')->name('upsells');
    Route::get('/{id}/upsells/edit','ProductController@editupsells')->name('editupsells');
    Route::post('/upsells/update','ProductController@updateupsells')->name('updateupsells');
    Route::post('/upsells/delete','ProductController@deleteupsells')->name('deleteupsells');
    Route::get('/import/print/{id}', 'ProductController@importprint')->name('importprint');
    //update general stock 
    Route::post('/stock-update','ProductController@updatestock')->name('updatestock');
    //list stock mapping
    Route::get('/stock-mapping/{id}','ProductController@stockmapping')->name('stockmapping');
    Route::post('/update-stock-mapping','ProductController@updatestockmapping')->name('updatestockmapping');
    //export
    Route::get('/export', 'ProductController@export')->name('export');
    Route::get('/export-download/{array}', 'ProductController@download')->name('download');
});

Route::group(['prefix'=>'leads','as'=>'leads.', 'middleware'=>['auth']], function(){
    Route::get('/', 'LeadController@index')->name('index');
    Route::get('/single', 'LeadController@single')->name('single');
    Route::get('/search', 'LeadController@search')->name('search');
    Route::get('/leadsearch', 'LeadController@leadsearch')->name('leadsearch');
    Route::get('/create', 'LeadController@create')->name('create');
    Route::get('/refresh', 'LeadController@refresh')->name('refresh');
    Route::post('/store', 'LeadController@store')->name('store')->middleware('plan.limits:monthly_sales');
    Route::post('/upsell', 'LeadController@upsellstore')->name('upsellstore');
    Route::post('/multi-upsell', 'LeadController@multiupsell')->name('multiupsell');
    Route::get('/packages', 'LeadController@packages')->name('packages');
    Route::get('/edit/{id}', 'LeadController@edit')->name('edit');
    Route::get('/{id}/details', 'LeadController@details')->name('details');
    Route::get('/{id}/infoupsell', 'LeadController@infoupsell')->name('infoupsell');
    Route::get('/{id}/seacrhdetails', 'LeadController@seacrhdetails')->name('seacrhdetails');
    Route::get('/{id}/detailspro', 'LeadController@detailspro')->name('detailspro');
    Route::post('/update', 'LeadController@update')->name('update');
    Route::get('/delete/{id}', 'LeadController@destroy')->name('delete');
    Route::post('/status-confirmation', 'LeadController@statuscon')->name('statuscon');
    Route::post('/confirmed', 'LeadController@confirmed')->name('confirmed');
    Route::post('/canceled', 'LeadController@canceled')->name('canceled');
    Route::get('/duplicated/{id}', 'LeadController@duplicated')->name('duplicated');
    Route::get('/horzone/{id}', 'LeadController@horzone')->name('horzone');
    Route::post('/wrong', 'LeadController@wrong')->name('wrong');
    Route::post('/outof-stock', 'LeadController@outofstocks')->name('outofstocks');
    Route::post('/date', 'LeadController@date')->name('date');
    Route::post('/note-status', 'LeadController@notestatus')->name('notestatus');
    Route::get('/settings', 'LeadController@settings')->name('settings');
    Route::get('/seehistory', 'LeadController@history')->name('seehistory');
    Route::post('/statc', 'LeadController@statusc')->name('statusc');
    Route::post('/statctest', 'LeadController@statusctest')->name('statusctest');
    Route::post('/call', 'LeadController@call')->name('call');
    Route::post('/blacklist','LeadController@blackList')->name('blacklist');
    Route::get('/new-order','LeadController@neworder')->name('neworder');
    //list Upsell
    Route::get('/{id}/listupsell', 'LeadController@listupsell')->name('listupsell');
    //delete upsell
    Route::get('/deleteupsell/{id}','LeadController@deleteupsell')->name('deleteupsell');
    //update price
    Route::post('/update-price','LeadController@updateprice')->name('updateprice');
    //no answer call
    Route::get('/another-leads','LeadController@another')->name('another');
    //out of stock
    Route::get('/out-of-stock','LeadController@outofstock')->name('outofstock');
    //export
    Route::post('/exports', 'LeadController@export2')->name('exports');
    Route::get('/export-downloads/{array}', 'LeadController@download2')->name('downloads');
    //refresh data
    Route::get('/refresh-data/{id}', 'LeadController@refresh')->name('refresh');
    //export cheked
    Route::post('/export', 'LeadController@export')->name('export');
    Route::get('/export-download/{array}', 'LeadController@download')->name('download');
    Route::post('/change','LeadController@change')->name('change');
    Route::get('/call-center/{id}','LeadController@callcenter')->name('callcenter');

    //call later
    Route::get('/call-later','LeadController@calllater')->name('calllater');
    Route::get('/lead-duplicated','LeadController@leadduplicated')->name('leadduplicated');
    Route::get('/lead-horzone','LeadController@leadhorzone')->name('leadhorzone');
    Route::get('/lead-wrong','LeadController@leadwrong')->name('leadwrong');
    Route::get('/lead-canceled','LeadController@leadcanceled')->name('leadcanceled');
    Route::get('/lead-canceled-by-system','LeadController@canceledbysystem')->name('canceledbysystem');
    //no answer list
    Route::get('/noanswer-list','LeadController@noanswer')->name('noanswer');
    //list order client
    Route::get('/client/{id}','LeadController@client')->name('client');
    //inassigned
    Route::get('/inassigned-lead','LeadController@inassigned')->name('inassigned');
    //discount
    Route::post('/discount','LeadController@discount')->name('discount');

    //orders incident
    Route::get('/orders/incident','LeadController@incident')->name('incident');

    Route::get('/rejected','LeadController@rejected')->name('rejected');
    //prepaid
    Route::get('/prepaid','LeadController@prepaid')->name('prepaid');
    //blacklist
    Route::get('/blackliste','LeadController@blackliste')->name('blackliste');
    //suivi
    Route::get('/suivi','LeadController@suivi')->name('suivi');
    //upload data
    Route::post('/import_parse', 'LeadController@parseImport')->name('import_parse');
    Route::post('/import_process', 'LeadController@processImport')->name('import_process');

    //recorde
    Route::post('/upload-voice','LeadController@voice')->name('voice');
});


Route::group(['prefix'=>'orders','as'=>'orders.', 'middleware'=>['auth']], function(){
    Route::get('/', 'OrderController@index')->name('index');
    Route::post('/statu-change','OrderController@change')->name('change');
});

Route::group(['prefix'=>'suppliers','as'=>'suppliers.', 'middleware'=>['auth']], function(){
    Route::get('/', 'SupplierController@index')->name('index');
    Route::post('/store', 'SupplierController@store')->name('store');
    Route::get('/{supplier}/details', 'SupplierController@details')->name('details');
    Route::post('/update/{id}', 'SupplierController@update')->name('update');
});

Route::get('/get-cities/{country}', function($countryId) {
    $cities = App\Models\Citie::where('id_country', $countryId)->pluck('name', 'id');
    return response()->json($cities);
});


Route::prefix('shopify')->group(function() {
    Route::get('/', [ShopifyController::class, 'index'])->name('shopify.index');
    Route::post('/', [ShopifyController::class, 'store'])->name('shopify.store');
    Route::post('/verify', [ShopifyController::class, 'verify'])->name('shopify.verify');
    Route::post('/delete', [ShopifyController::class, 'destroy'])->name('shopify.delete');
});

Route::post('/webhooks/order/{accountId}', 'WebhookController@OrderCreated')->name('orderCreated')->middleware('plan.limits:monthly_sales');
Route::post('/webhook/youcan', 'YoucanWebhookController@orderCreatedYouCan')->name('youcanOrderCreated')->middleware('plan.limits:monthly_sales');
Route::post('/webhook/shopify/{id}', 'ShopifyWebhookController@orderCreatedShopify')->name('shopifyOrderCreated')->middleware('plan.limits:monthly_sales');


Route::prefix('webhook')->group(function () {
    Route::post('/whatsapp', [WhatsAppWebhookController::class, 'handleIncoming'])->name('webhook.whatsapp');
});


Route::group(['prefix'=>'relancements','as'=>'relancements.', 'middleware'=>['auth']], function(){
    Route::get('/{id}', 'RelancementController@index')->name('index');
    Route::get('/create', 'RelancementController@create')->name('create');
    Route::post('/store/{id}', 'RelancementController@store')->name('store');
});


Route::group(['prefix'=>'reclamations','as'=>'reclamations.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ReclamationController@index')->name('index');
    Route::get('/create', 'ReclamationController@create')->name('create');
    Route::post('/store', 'ReclamationController@store')->name('store');
    Route::get('/{id}/edit', 'ReclamationController@edit')->name('edit');
    Route::post('/update/{id}', 'ReclamationController@update')->name('update');
    Route::post('/delete', 'ReclamationController@destroy')->name('delete');
    Route::get('/download', 'ReclamationController@download')->name('download');
});

Route::group(['prefix'=>'countries','as'=>'countries.', 'middleware'=>['auth']], function(){
    Route::get('/', 'CountrieController@index')->name('index');
    Route::get('/create', 'CountrieController@create')->name('create');
    Route::post('/store', 'CountrieController@store')->name('store');
    Route::get('/{id}/details', 'CountrieController@details')->name('details');
    Route::post('/update', 'CountrieController@update')->name('update');
    Route::post('/delete', 'CountrieController@destroy')->name('delete');
});

Route::group(['prefix'=>'warehouses','as'=>'warehouses.', 'middleware'=>['auth']], function(){
    Route::get('/', 'WarehouseController@index')->name('index');
    Route::get('/create', 'WarehouseController@create')->name('create');
    Route::post('/store', 'WarehouseController@store')->name('store');
    Route::get('/{id}/details', 'WarehouseController@details')->name('details');
    Route::post('/update', 'WarehouseController@update')->name('update');
    Route::post('/delete', 'WarehouseController@destroy')->name('delete');
    Route::get('/overview/{id}','WarehouseController@overview')->name('overview');
    Route::get('/cities/{id}','WarehouseController@cities')->name('cities');
    Route::post('/assigned','WarehouseController@assigned')->name('assigned');
});

Route::group(['prefix'=>'cities','as'=>'cities.', 'middleware'=>['auth']], function(){
    Route::get('/', 'CitieController@index')->name('index');
    Route::get('/create', 'CitieController@create')->name('create');
    Route::post('/store', 'CitieController@store')->name('store');
    Route::get('/{id}/details', 'CitieController@details')->name('details');
    Route::post('/update', 'CitieController@update')->name('update');
    Route::post('/delete', 'CitieController@destroy')->name('delete');
    Route::post('/upload', 'CitieController@upload')->name('upload');
    Route::get('/active/{id}', 'CitieController@active')->name('active');
    Route::get('/inactive/{id}', 'CitieController@inactive')->name('inactive');
});

Route::group(['prefix'=>'zones','as'=>'zones.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ZoneController@index')->name('index');
    Route::get('/create', 'ZoneController@create')->name('create');
    Route::post('/store', 'ZoneController@store')->name('store');
    Route::get('/{id}/edit', 'ZoneController@edit')->name('edit');
    Route::post('/update/{id}', 'ZoneController@update')->name('update');
    Route::post('/delete', 'ZoneController@destroy')->name('delete');
});

Route::group(['prefix'=>'sheets','as'=>'sheets.', 'middleware'=>['auth']], function(){
    Route::get('/', 'SheetController@index')->name('index');
    Route::get('/create', 'SheetController@create')->name('create');
    Route::post('/store', 'SheetController@store')->name('store');
    Route::get('/{id}/edit', 'SheetController@edit')->name('edit');
    Route::post('/update', 'SheetController@update')->name('update');
    Route::post('/delete', 'SheetController@destroy')->name('delete');
    Route::get('/download', 'SheetController@download')->name('download');
    Route::get('/{id}/rows', 'SheetController@rows')->name('rows');
    Route::post('/rowsupdate', 'SheetController@rowsupdate')->name('rowsupdate');
});

Route::group(['prefix'=>'imports','as'=>'imports.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ImportController@index')->name('index');
    Route::get('/create', 'ImportController@create')->name('create');
    Route::post('/store', 'ImportController@store')->name('store');
    Route::get('/{id}/edit', 'ImportController@edit')->name('edit');
    Route::post('/update', 'ImportController@update')->name('update');
    Route::get('/delete/{id}', 'ImportController@destroy')->name('delete');
    Route::get('/download', 'ImportController@download')->name('download');
});

Route::group(['prefix'=>'reclamations','as'=>'reclamations.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ReclamationController@index')->name('index');
    Route::get('/create', 'ReclamationController@create')->name('create');
    Route::post('/store', 'ReclamationController@store')->name('store');
    Route::get('/{id}/edit', 'ReclamationController@edit')->name('edit');
    Route::post('/update/{id}', 'ReclamationController@update')->name('update');
    Route::post('/delete', 'ReclamationController@destroy')->name('delete');
    Route::get('/download', 'ReclamationController@download')->name('download');
    Route::post('/statuscon', 'ReclamationController@statuscon')->name('statuscon');
});

Route::group(['prefix'=>'customers','as'=>'customers.', 'middleware'=>['auth']], function(){
    Route::get('/', 'CustomerController@index')->name('index');
    Route::post('/paied', 'CustomerController@paied')->name('paied');
    Route::post('/paiedall', 'CustomerController@paiedall')->name('paiedall');
    Route::post('/store', 'CustomerController@store')->name('store');
    Route::get('/{id}/edit', 'CustomerController@edit')->name('edit');
    Route::post('/update/{id}', 'CustomerController@update')->name('update');
    Route::post('/details', 'CustomerController@details')->name('details');
    Route::post('/delete', 'CustomerController@destroy')->name('delete');
    Route::get('/situation', 'CustomerController@situation')->name('situation');
    Route::get('/orders/{id}', 'CustomerController@orders')->name('orders');
    Route::get('/active/{id}', 'CustomerController@active')->name('active');
    Route::get('/inactive/{id}', 'CustomerController@inactive')->name('inactive');
    Route::get('/{id}/details', 'CustomerController@detail')->name('detail');
    Route::get('/fees/{id}', 'CustomerController@fees')->name('fees');
    Route::post('/feesstore', 'CustomerController@feesstore')->name('feesstore');
    Route::get('/{id}/fees', 'CustomerController@feesupdate')->name('feesupdate');
    Route::post('/editfees', 'CustomerController@editfees')->name('feesedit');
    //document
    Route::get('/document/{id}','CustomerController@document')->name('document');
    //parameters
    Route::get('/parameter/{id}','CustomerController@parameter')->name('parameter');
    Route::post('/parameter-create','CustomerController@parametercreate')->name('parametercreate');
    Route::post('/parameter-update','CustomerController@parameterupdate')->name('parameterupdate');
    Route::get('/check', 'CustomerController@check')->name('check');
});
Route::get('/profil','UserController@profil')->name('profil');
Route::post('/profilss','UserController@updateprofil')->name('update');
Route::post('/profils','UserController@updatesprofil')->name('updates');
Route::get('/profil/document','UserController@document')->name('document');

Route::group(['prefix'=>'invoices','as'=>'invoices.', 'middleware'=>['auth']], function(){
    Route::get('/', 'InvoiceController@index')->name('index');
    Route::post('/paied', 'InvoiceController@paied')->name('paied');
    Route::get('/paied/{id}', 'InvoiceController@paid')->name('paid');
    Route::get('/print/{id}', 'InvoiceController@print')->name('print');
    Route::get('/update/{id}', 'InvoiceController@update')->name('update');
    Route::post('/updateref','InvoiceController@updateref')->name('updateref');
    Route::get('/delete/{id}', 'InvoiceController@delete')->name('delete');
    Route::get('/delete-lead/{id}', 'InvoiceController@lead')->name('lead');
    Route::get('/printfiscal/{id}', 'InvoiceController@printfiscal')->name('printfiscal');
    Route::get('/delete-import/{id}', 'InvoiceController@import')->name('import');
    Route::post('/export', 'InvoiceController@export')->name('export');
    Route::get('/export-download/{array}', 'InvoiceController@download')->name('download');
    Route::get('/download-invoice', 'InvoiceController@downloadInvoices')->name('downloadInvoice');
    Route::get('/externel', 'InvoiceController@externel')->name('externel');
    Route::get('/store', 'InvoiceController@store')->name('store');
    Route::get('/active/{id}', 'InvoiceController@active')->name('active');
    Route::get('/inactive/{id}', 'InvoiceController@inactive')->name('inactive');
});

Route::group(['prefix'=>'companies','as'=>'companies.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ShippingCompanyController@index')->name('index');
    Route::get('/create', 'ShippingCompanyController@create')->name('create');
    Route::post('/store', 'ShippingCompanyController@store')->name('store')->middleware('plan.limits:shipping_companies');
    Route::get('/{id}/edit', 'ShippingCompanyController@edit')->name('edit');
    Route::post('/update', 'ShippingCompanyController@update')->name('update');
    Route::post('/delete', 'ShippingCompanyController@destroy')->name('delete');
});

Route::group(['prefix'=>'last-mille','as'=>'last-mille.', 'middleware'=>['auth']], function(){
    Route::get('/', 'LastmilleCompanyController@index')->name('index');
    Route::post('/store','LastmilleIntegrationController@store')->name('store');
    Route::post('/update/{id}','LastmilleIntegrationController@update')->name('update');
    Route::get('/{id}', 'LastmilleIntegrationController@details')->name('details');
    Route::get('/active/{id}', 'LastmilleIntegrationController@active')->name('active');
    Route::get('/inactive/{id}', 'LastmilleIntegrationController@inactive')->name('inactive');
    Route::get('/deleted/{id}', 'LastmilleIntegrationController@destroy')->name('deleted');
});

Route::group(['prefix'=>'users','as'=>'users.', 'middleware'=>['auth']], function(){
    Route::get('/', 'UserController@index')->name('index');
    Route::post('/store', 'UserController@store')->name('store')->middleware('plan.limits:users');
    Route::get('/{id}/edit', 'UserController@edit')->name('edit');
    Route::post('/update', 'UserController@update')->name('update');
    Route::post('/delete', 'UserController@destroy')->name('delete');
    Route::get('/reset', 'UserController@reset')->name('reset');
    Route::post('/active', 'UserController@active')->name('active');
    Route::post('/inactive', 'UserController@inactive')->name('inactive');
    Route::post('/password', 'UserController@password')->name('password');  
});


Route::group(['prefix'=>'clients','as'=>'clients.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ClientController@index')->name('index');
    Route::post('/export', 'ClientController@export')->name('export');
    Route::get('/{client}/details', 'ClientController@details')->name('details');
    Route::post('/{client}/add-note', 'ClientController@addNote')->name('addNote');
});

Route::post('/communications', 'CommunicationController@store')->name('communications.store');

Route::group(['prefix'=>'statistics','as'=>'statistics.', 'middleware'=>['auth']], function(){
    Route::get('/{type}', 'StatisticsController@index')->name('index');
    Route::get('/details/{id}', 'StatisticsController@details')->name('details');
    Route::post('/store', 'StatisticsController@store')->name('store');
    Route::get('/{id}/edit', 'StatisticsController@edit')->name('edit'); 
    Route::post('/update/{id}', 'StatisticsController@update')->name('update');
});

Route::group(['prefix'=>'callcenter','as'=>'callcenter.', 'middleware'=>['auth']], function(){
    Route::get('/', 'CallcenterController@index')->name('index');
    Route::get('/{type}', 'CallcenterController@costumer')->name('costumer');
    Route::get('/details/{id}', 'CallcenterController@details')->name('details');
    Route::post('/store', 'CallcenterController@store')->name('store');
    Route::post('/filter', 'CallcenterController@filter')->name('filter'); 
    Route::get('/{id}/edit', 'CallcenterController@edit')->name('edit');
    Route::post('/update/{id}', 'CallcenterController@update')->name('update');
});

Route::group(['prefix'=>'sourcing','as'=>'sourcing.', 'middleware'=>['auth']], function(){
    Route::get('/', 'SourcingController@index')->name('index');
    Route::get('/create', 'SourcingController@create')->name('create');
    Route::post('/store', 'SourcingController@store')->name('store');
    Route::get('/edit/{id}', 'SourcingController@edit')->name('edit');
    Route::post('/update', 'SourcingController@update')->name('update');
    Route::get('/delete/{id}', 'SourcingController@destroy')->name('delete');
    Route::get('/canceled/{id}','SourcingController@canceled')->name('canceled');
    Route::post('/statuscon','SourcingController@statuscon')->name('statuscon');
    Route::post('/statusliv','SourcingController@statusliv')->name('statusliv');
    Route::post('/paid', 'SourcingController@paid')->name('paid');
});

Route::group(['prefix'=>'documents','as'=>'documents.', 'middleware'=>['auth']], function(){
    Route::get('/', 'DocumentController@index')->name('index');
    Route::post('/store', 'DocumentController@store')->name('store');
    Route::get('/{id}/edit', 'DocumentController@edit')->name('edit');
    Route::post('/update/{id}', 'DocumentController@update')->name('update');
});

Route::group(['prefix' => 'parameters','as' => 'parameters.', 'middleware' => ['auth']], function(){
    Route::get('/','ParameterController@index')->name('index');
    Route::post('/store','ParameterController@store')->name('store');
    Route::post('/update','ParameterController@update')->name('update');
});

Route::group(['prefix' => 'announcements','as' => 'announcements.', 'middleware' => ['auth']], function(){
    Route::get('/','AnnouncementController@index')->name('index');
    Route::post('/store','AnnouncementController@store')->name('store');
    Route::post('/update','AnnouncementController@update')->name('update');
    Route::get('/active/{id}', 'AnnouncementController@active')->name('active');
    Route::get('/delete/{id}', 'AnnouncementController@destroy')->name('delete');
    Route::get('/inactive/{id}', 'AnnouncementController@inactive')->name('inactive');
});

Route::group(['prefix' => 'offers','as' => 'offers.', 'middleware' => ['auth']], function(){
    Route::get('/','OfferController@index')->name('index');
    Route::get('/pending-offers','OfferController@pendingOffers')->name('pendingOffers');
    Route::get('/details/{id}', 'OfferController@details')->name('details');
    Route::get('/accept-offer', 'OfferController@acceptOffer')->name('acceptOffer');
    Route::get('/desactivated-offer', 'OfferController@desactivatedOffer')->name('desactivatedOffer');

   
    Route::post('/update','OfferController@update')->name('update');
    // Route::get('/active/{id}', 'OfferController@active')->name('active');
    // Route::get('/inactive/{id}', 'OfferController@inactive')->name('inactive');
});

// Route::group(['prefix'=>'shopify','as'=>'shopify.', 'middleware'=>['auth']], function(){
//     Route::get('/', 'ShopifyController@index')->name('index');
//     Route::post('/store', 'ShopifyController@store')->name('store');
//     Route::post('/delete', 'ShopifyController@destroy')->name('delete');
// });

Route::group(['prefix'=>'lightfunnels','as'=>'lightfunnels.', 'middleware'=>['auth']], function(){
    Route::get('/', 'LightfunnelsController@index')->name('index');
    Route::post('/toggle-status', 'LightfunnelsController@toggleStatus')->name('toggle-status');
 });

Route::group(['prefix'=>'youcan','as'=>'youcan.', 'middleware'=>['auth']], function(){
    Route::get('/', 'YoucanController@index')->name('index');
    Route::post('/auth', 'YoucanController@youcanAuth')->name('auth');
    Route::get('/callback', 'YoucanController@youcanCallback')->name('callback');
    Route::delete('/{storeId}', 'YoucanController@destroy')->name('destroy');
});

Route::group(['prefix'=>'banks','as'=>'banks.', 'middleware'=>['auth']], function(){
    Route::get('/', 'BankController@index')->name('index');
    Route::post('/store', 'BankController@store')->name('store');
    Route::post('/delete', 'BankController@destroy')->name('delete');
});

Route::group(['prefix'=>'guides','as'=>'guides.', 'middleware'=>['auth']], function(){
    Route::get('/', 'GuideController@index')->name('index');
    Route::post('/store', 'GuideController@store')->name('store');
    Route::get('/delete/{id}', 'GuideController@destroy')->name('delete');
});

Route::group(['prefix'=>'speends','as'=>'speends.', 'middleware'=>['auth']], function(){
    Route::get('/', 'SpeendadsController@index')->name('index');
    Route::get('/product/{id}','SpeendadsController@product')->name('product');
    Route::post('/product-store','SpeendadsController@productstore')->name('productstore');
    Route::get('/paltform/{id}','SpeendadsController@speend')->name('speend');
    Route::get('/create', 'SpeendadsController@create')->name('create');
    Route::get('/store/{id}', 'SpeendadsController@details')->name('details');
    Route::post('/store', 'SpeendadsController@store')->name('store');
});

Route::group(['prefix'=>'plateformes','as'=>'plateformes.', 'middleware'=>['auth']], function(){
    Route::get('/', 'PlateformController@index')->name('index');
});


Route::group(['prefix'=>'plugins','as'=>'plugins.', 'middleware'=>['auth']], function(){
    Route::get('/', function () {
        return view('backend.plugins.index');
    })->name('index');
    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
            Route::get('/', [WhatsAppDashboardController::class, 'index'])->name('index');
            Route::get('/account/{account}/metrics', [WhatsAppDashboardController::class, 'getAccountMetrics'])
                ->name('account.metrics');

            Route::get('/account/{account}/message-analytics', [WhatsAppDashboardController::class, 'getMessageAnalytics'])
                ->name('account.message-analytics');

            Route::get('/account/{account}/chatbot-status', [WhatsAppDashboardController::class, 'getChatbotStatus'])
                ->name('account.chatbot-status');
            Route::post('/account/{account}/chatbot-status', [WhatsAppDashboardController::class, 'updateChatbotStatus'])
                ->name('account.update-chatbot-status');

            Route::get('/account-details', [WhatsAppController::class, 'accountDetails'])->name('account.details');
            Route::post('/exchange-token', [WhatsAppController::class, 'accessToken'])->name('exchange-token');

            Route::post('/sync-templates', [WhatsAppController::class, 'syncTemplates'])->name('templates.sync');
            Route::post('/assign-agents', [WhatsAppController::class, 'assignAgents'])->name('assign-agents');
            Route::get('/{account}/agents/manage', [WhatsAppController::class, 'manageAgents'])->name('agents.manage');
            
            Route::prefix('templates')->group(function () {
                Route::get('confirmation', [WhatsAppTemplateController::class, 'index'])->name('confirmation-templates.index');
                Route::get('confirmation-notifications', [WhatsAppTemplateController::class, 'confirmationNotifications'])->name('confirmationNotification-templates.index');
                Route::get('delivery-notifications', [WhatsAppTemplateController::class, 'deliveryNotifications'])->name('notification-templates.index');
            });
            
            Route::get('offers', [WhatsAppController::class, 'index'])->name('offers.index');
            
            Route::get('analytics', [WhatsAppAnalyticsController::class, 'index'])->name('analytics');
            
            Route::prefix('numbers')->group(function () {
                Route::get('/', [WhatsAppNumberController::class, 'index'])->name('numbers.index');
            });
            
            Route::prefix('settings')->group(function () {
                Route::get('/', [WhatsAppController::class, 'index'])->name('settings.index');
                Route::post('save', [WhatsAppController::class, 'save'])->name('settings.save');
                Route::get('get', [WhatsAppController::class, 'get'])->name('settings.get');
            });
    });
});




Route::get('/privacy-policy', function () {
    return view('backend.privacy-policy');
})->name('privacy-policy');

Route::group(['prefix' => 'whatsapp-numbers','as' => 'whatsapp-numbers.','middleware' => ['auth']], function() {
    Route::get('/', [WhatsAppAccountController::class, 'index'])
         ->name('index');

    Route::get('/callback', [WhatsAppAccountController::class, 'handleCallback'])
         ->name('callback');
    
    Route::post('/', [WhatsAppAccountController::class, 'store'])
         ->name('store');
    
    Route::delete('/{account}', [WhatsAppAccountController::class, 'destroy'])
         ->name('destroy');
    
    Route::post('/import', [WhatsAppAccountController::class, 'importBackup'])
         ->name('import');
         
    Route::get('/{account}/webhook-url', function(WhatsappBusinessAccount $account) {
        return response()->json([
            'webhook_url' => route('whatsapp-numbers.webhook', $account->webhook_token)
        ]);
    })->name('webhook-url');
});


// Route::group(['prefix' => 'whatsapp-template','as' => 'whatsapp-template.','middleware' => ['auth']], function() {
//     Route::get('/', [WhatsappUIController::class, 'index'])
//          ->name('index');
//     Route::get('/search-messages', [WhatsappUIController::class, 'searchMessages'])
//         ->name('search-messages');


//     Route::get('/chat/{account}', [WhatsappUIController::class, 'index'])
//          ->name('chat');

//     Route::post('/send-message', [WhatsAppAccountController::class, 'sendMessage'])
//          ->name('send-message');

//     Route::post('/media/{filename}', [WhatsappUIController::class, 'getFile'])
//          ->name('media');
    
//     Route::post('/conversations/{conversation}/mark-as-read', [WhatsappUIController::class, 'markAsRead'])
//          ->name('conversations.mark-as-read');
//     Route::post('/send-template', [WhatsappUIController::class, 'sendTemplate'])->name('send-template');
//     Route::get('/templates', [WhatsappUIController::class, 'getTemplates'])->name('templates');
    
// });


// WhatsApp routes
Route::group(['prefix' => 'whatsapp-template','as' => 'whatsapp-template.','middleware' => ['auth']], function() {
    Route::get('/', [WhatsappUIController::class, 'index'])
          ->name('index');
    Route::get('/search-messages', [WhatsappUIController::class, 'searchMessages'])
        ->name('search-messages');
    Route::get('/get-accounts', [WhatsappUIController::class, 'getAccounts'])
        ->name('get-accounts');
    
    Route::get('/get-conversations', [WhatsappUIController::class, 'getConversations'])
        ->name('get-conversations');
    
    Route::get('/get-messages', [WhatsappUIController::class, 'getMessages'])
        ->name('get-messages');
    
    Route::post('/send-message', [WhatsappUIController::class, 'sendMessage'])
        ->name('send-message');
    
    Route::post('/conversations/{conversation}/mark-as-read', [WhatsappUIController::class, 'markAsRead'])
        ->name('mark-as-read');
    
    Route::get('/media/{filename}', [WhatsappUIController::class, 'getFile'])
        ->name('get-file');

    Route::post('/send-template', [WhatsappUIController::class, 'sendTemplate'])->name('send-template');
    Route::get('/templates', [WhatsappUIController::class, 'getTemplates'])->name('templates');

    Route::post('/check-conversation', [WhatsappUIController::class, 'checkConversation'])
    ->name('check-conversation');

    Route::post('/check-contact', [WhatsappUIController::class, 'checkContact'])
    ->name('check-contact');

    Route::put('/update-contact/{conversation}', [WhatsappUIController::class, 'updateContact'])
        ->name('update-contact');

    Route::delete('/conversations/{conversation}', [WhatsappUIController::class, 'destroyConversation'])
        ->name('destroy-conversation');

    Route::get('/get-contact-details/{phoneNumber}', [WhatsappUIController::class, 'getContactDetails'])->name('contact-details');
    Route::post('/update-contact-details/{id}', [WhatsappUIController::class, 'updateContactDetails'])->name('update-contact-details');

    Route::post('/messages/delete', [WhatsappUIController::class, 'deleteMessage'])->name('whatsapp-template.messages.delete');
    Route::post('/conversations/{conversation}/block', [WhatsappUIController::class, 'blockConversation']);
    Route::post('/conversations/{conversation}/unblock', [WhatsappUIController::class, 'unblockConversation']);
    Route::get('/labels', [WhatsappUIController::class, 'getLabels']);
    Route::post('/labels', [WhatsappUIController::class, 'createLabel']);
    Route::delete('/labels/{id}', [WhatsappUIController::class, 'deleteLabel']);
    Route::get('/labels/conversations', [WhatsappUIController::class, 'getConversationsByLabel']);
    Route::post('/conversations/{conversation}/labels/assign', [WhatsappUIController::class, 'assignLabels']);
    Route::post('/store-lead', [WhatsappUIController::class,'storeLead'])->name('storeLead');
});


// Route::group(['prefix' => 'whatsapp-offers', 'middleware' => ['auth']], function() {
//     Route::get('/', [NotificationOffersController::class, 'index'])->name('whatsapp-offers.index');
//     Route::post('/get-template', [NotificationOffersController::class, 'getTemplate']);
//     Route::post('/save-template', [NotificationOffersController::class, 'saveTemplate']);
//     Route::post('/create-template', [NotificationOffersController::class, 'createNewTemplate']);
//     Route::post('/get-template-details', [NotificationOffersController::class, 'getTemplateDetails']);
//     Route::post('/send-offer', [NotificationOffersController::class, 'sendOffer']);
//     Route::post('/delete-template', [NotificationOffersController::class, 'deleteTemplate'])->name('whatsapp-offers.delete-template');
//     Route::post('/send-bulk-offers', [NotificationOffersController::class, 'sendBulkOffers']);
// });



// Route::group(['prefix' => 'confirmation-templates', 'middleware' => ['auth']], function() {
//     Route::get('/', [ConfirmationTemplateController::class, 'index'])->name('confirmation-templates.index');
//     Route::post('/get-template', [ConfirmationTemplateController::class, 'getTemplate'])->name('confirmation.get');
//     Route::post('/save-template', [ConfirmationTemplateController::class, 'saveTemplate'])->name('confirmation.save');
// });

Route::prefix('whatsapp-analytics')->group(function () {
    Route::get('/', [WhatsappAnalyticsController::class, 'index'])->name('whatsapp-analytics');
    Route::post('/save-preferences', [WhatsappAnalyticsController::class, 'savePreferences'])->name('save-whatsapp-preferences');
    Route::get('/get-preferences', [WhatsappAnalyticsController::class, 'getPreferences'])->name('get-whatsapp-preferences');
});


Route::group(['prefix'=>'parrainage','as'=>'parrainage.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ParinageController@index')->name('index');
    Route::get('/newusers', 'ParinageController@newusers')->name('newusers');
    Route::post('/store', 'ParinageController@store')->name('store');
    Route::post('/update', 'ParinageController@update')->name('update');
    Route::post('/delete', 'ParinageController@destroy')->name('delete');
    //Route::delete('/multidelete', 'CitieController@multidelete')->name('multidelete');
});

Route::group(['prefix'=>'campaigne','as'=>'campaigne.', 'middleware'=>['auth']], function(){
    Route::get('/', 'CampaigneDataController@index')->name('index');
    Route::get('/create', 'CampaigneDataController@create')->name('create');
    Route::post('/store', 'CampaigneDataController@store')->name('store');
    Route::get('/view/{id}', 'CampaigneDataController@view')->name('view');
});

Route::group(['prefix'=>'woocommerce','as'=>'woocommerce.', 'middleware'=>['auth']], function(){
    Route::get('/', 'WocoomerceController@index')->name('index');
    Route::get('/create', 'WocoomerceController@create')->name('create');
    Route::post('/store', 'WocoomerceController@store')->name('store');
    Route::get('/{id}/edit', 'WocoomerceController@edit')->name('edit');
    Route::post('/update', 'WocoomerceController@update')->name('update');
    Route::post('/delete', 'WocoomerceController@destroy')->name('delete');
    Route::get('/download', 'WocoomerceController@download')->name('download');
    Route::get('/read', 'WocoomerceController@read')->name('read');
});

Route::group(['prefix' => 'woocommerce', 'as' => 'woocommerce.'], function() {
    Route::get('/', [WooCommerceIntegrationController::class, 'index'])->name('index');
    Route::post('/', [WooCommerceIntegrationController::class, 'store'])->name('store');
    Route::delete('/{id}', [WooCommerceIntegrationController::class, 'destroy'])->name('destroy');
});



Route::group(['prefix'=>'category-expense','as'=>'categoryexpense.', 'middleware'=>['auth']], function(){
    Route::get('/', 'CategoryExpenseController@index')->name('index');
    Route::get('/create', 'CategoryExpenseController@create')->name('create');
    Route::post('/store', 'CategoryExpenseController@store')->name('store');
    Route::get('/{id}/edit', 'CategoryExpenseController@edit')->name('edit');
    Route::post('/update', 'CategoryExpenseController@update')->name('update');
    Route::post('/delete', 'CategoryExpenseController@destroy')->name('delete');
});

Route::group(['prefix'=>'expenses','as'=>'expenses.', 'middleware'=>['auth']], function(){
    Route::get('/', 'ExpenseController@index')->name('index');
    Route::get('/create', 'ExpenseController@create')->name('create');
    Route::post('/store', 'ExpenseController@store')->name('store');
    Route::get('/{id}/edit', 'ExpenseController@edit')->name('edit');
    Route::post('/update', 'ExpenseController@update')->name('update');
    Route::post('/delete', 'ExpenseController@destroy')->name('delete');
});



Route::middleware('auth')->group(function () {
    Route::get('/agent-status/agents', [AgentStatusController::class, 'getAgents']);
    Route::get('/agent-status/history/{agentId}', [AgentStatusController::class, 'getAgentHistory']);
    Route::get('/agent/details','AnalyticsController@details')->name('agents.details');
});

Route::post('/dashboard/ajax', [HomeController::class, 'ajaxDashboard'])->middleware('auth')->name('dashboard.ajax');


// Route::get('/test-lead-observer', function() {
//     $lead = Lead::latest()->first();
    
//     if (!$lead) {
//         return "No leads found in database";
//     }

//     $lead->status_livrison = 'returned';
//     $lead->save();

//     return "Observer triggered for lead ID: {$lead->id}";
// });

// Route::get('/test-orders', [HomeController::class, 'getOrders']);
// Route::get('/test-stores', [HomeController::class, 'getStores']);

// Route::get('/test/whatsapp-analytics', function() {
//     $controller = new WhatsappAnalyticsController();
    
//     $daily = $controller->sendWhatsappAnalytics('daily');
    
//     $weekly = $controller->sendWhatsappAnalytics('weekly');
    
//     $monthly = $controller->sendWhatsappAnalytics('monthly');
    
//     return response()->json([
//         'daily' => $daily->getData(),
//         'weekly' => $weekly->getData(),
//         'monthly' => $monthly->getData()
//     ]);
// });


// Route::get('/test/lead-status', function() {
//     $lead = Lead::first();
//     if (!$lead) {
//         return response()->json(['error' => 'No lead found'], 404);
//     }
//     $lead->status_livrison = 'unpacked';
//     $lead->save();
    
//     return response()->json(['message' => 'Lead status updated successfully', 'lead' => $lead], 200);
// });

//Whatsapp 

// Route::group(['prefix'=>'whatsapp','as'=>'whatsapp.', 'middleware'=>['auth']], function(){
//     Route::get('/', [UltraMessageAccountController::class, 'index'])->name('index');
//     Route::post('/', [UltraMessageAccountController::class, 'store'])->name('store');
//     Route::delete('/{whatsappAccount}', [UltraMessageAccountController::class, 'destroy'])->name('destroy');
//     Route::get('/settings', [WhatsAppController::class, 'getSettings'])->name('settings.get');
//     Route::post('/settings', [WhatsAppController::class, 'saveSettings'])->name('settings.save');
//     Route::post('/notify-missed-call', [WhatsAppController::class, 'notifyMissedCall'])->name('notify-missed-call');
    
//     Route::post('/register', [WhatsAppAccountController::class, 'register'])
//     ->name('register');

//     Route::post('/manual-register', [WhatsAppAccountController::class, 'manualRegister'])
//         ->name('manual-register');

//     Route::prefix('accounts')->group(function () {
//         Route::get('/{id}', [WhatsAppAccountController::class, 'show']);
//         Route::post('/{id}/sync', [WhatsAppAccountController::class, 'sync']);
//         Route::delete('/{id}', [WhatsAppAccountController::class, 'destroy']);
//     });
    
// });

// WhatsApp Business Accounts
Route::prefix('whatsapp/business-accounts')->group(function () {
    Route::post('/', [WhatsAppBusinessAccountController::class, 'register']);
    Route::get('/', [WhatsAppBusinessAccountController::class, 'index']);
    Route::get('/{id}', [WhatsAppBusinessAccountController::class, 'show']);
    Route::put('/{id}', [WhatsAppBusinessAccountController::class, 'update']);
    Route::delete('/{id}', [WhatsAppBusinessAccountController::class, 'destroy']);
});

// WhatsApp Numbers
Route::prefix('whatsapp/business-accounts/{accountId}/numbers')->group(function () {
    Route::post('/', [WhatsAppNumberController::class, 'register']);
    Route::get('/', [WhatsAppNumberController::class, 'index']);
    Route::get('/{numberId}', [WhatsAppNumberController::class, 'show']);
    Route::put('/{numberId}', [WhatsAppNumberController::class, 'update']);
    Route::delete('/{numberId}', [WhatsAppNumberController::class, 'destroy']);
});

// WhatsApp Templates
Route::prefix('whatsapp/business-accounts/{accountId}/templates')->middleware('auth')->group(function () {
  Route::get('/', [WhatsAppTemplateController::class, 'index'])->name('whatsapp-templates.index');
    Route::get('/data', [WhatsAppTemplateController::class, 'getTemplatesData'])->name('whatsapp-templates.data');
    Route::get('/whatsapp-data', [WhatsAppTemplateController::class, 'getWhatsAppTemplatesData'])->name('whatsapp-templates.whatsapp-data');
    Route::get('/create', [WhatsAppTemplateController::class, 'create'])->name('whatsapp-templates.create');
    Route::post('/', [WhatsAppTemplateController::class, 'store'])->name('whatsapp-templates.store');
    Route::get('/{templateId}', [WhatsAppTemplateController::class, 'show'])->name('whatsapp-templates.show');
    Route::delete('/{templateId}', [WhatsAppTemplateController::class, 'destroy'])->name('whatsapp-templates.destroy');
    Route::post('/bulk-delete', [WhatsAppTemplateController::class, 'bulkDestroy'])->name('whatsapp-templates.bulk-delete');
});


// WhatsApp Messages
// Route::prefix('whatsapp/numbers/{numberId}/messages')->group(function () {
//     Route::post('/text', [WhatsAppMessageController::class, 'sendText']);
//     Route::post('/template', [WhatsAppMessageController::class, 'sendTemplate']);
//     Route::get('/logs', [WhatsAppMessageController::class, 'logs']);
// });

// Flow Management
Route::prefix('whatsapp/business-accounts/{businessAccount}/flows')->middleware('auth')->group(function() {
    Route::get('/', [FlowController::class, 'index'])->name('business.flows.index');
    Route::get('/create', [FlowController::class, 'create'])->name('business.flows.create');
    Route::post('/', [FlowController::class, 'store'])->name('business.flows.store');
    Route::post('/{flow}', [FlowController::class, 'store'])->name('business.flows.update');
    Route::get('/{flow}', [FlowController::class, 'show'])->name('business.flows.show');
    Route::get('/{flow}/edit', [FlowController::class, 'edit'])->name('business.flows.edit');
    Route::put('/{flow}', [FlowController::class, 'update'])->name('business.flows.update');
    Route::delete('/{flow}', [FlowController::class, 'destroy'])->name('business.flows.destroy');
});


//Media Uploads
Route::post('/upload-media', [MediaController::class, 'upload'])->name('media.upload');
Route::post('/upload-media/meta', [MediaController::class, 'uploadMetaMedia'])->name('media.upload.meta');
Route::post('/delete-media', [MediaController::class, 'delete'])->name('media.delete');


// Route::get('/whatsapp/chatflow',function() {
//         return view('backend.plugins.whatsapp.chatflow.create',['businessAccount' => 12]);
// })->middleware('auth');

// Route::get('/whatsapp/templates', function () {
//     return view('backend.plugins.whatsapp.template.index',['businessAccount' => 12]);
// })->middleware('auth');


Route::get('/test-lead-create', function () {
    try {
        $lead = new App\Models\Lead();
        $lead->name = "Test Customer";
        $lead->phone = "212701130792";
        $lead->email = "test@example.com";
        $lead->id_user = 1;
        $lead->status_confirmation = "new order";
        $lead->status_livrison = "unpacked";
        $lead->address = "123 Test Street";
        $lead->city = "Test City";
        $lead->id_country = 11; 
        $lead->save();


             $notification = Notification::create([
                'user_id' => Auth::user()->id,
                'type' => 'warning',
                'title' => 'Order already processed',
                'message' => "Order ID: $1",
            ]);

        
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


        $pusher->trigger('user.' . Auth::user()->id, 'Notification', $data);
        


        

        return response()->json([
            'success' => true,
            'message' => 'Test lead created successfully!',
            'lead_id' => $lead->id,
            'lead_name' => $lead->name,
            'phone' => $lead->phone
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
});


   


Route::prefix('whatsapp')->middleware("auth")->group(function () {
    Route::get('/get-assigned-agent/{clientId}', [AgentWhatsappController::class, 'getAssignedAgent']);
    Route::get('/agents-with-workload', [AgentWhatsappController::class, 'getAgentsWithWorkload']);
    Route::post('/assign-conversation', [AgentWhatsappController::class, 'assignConversation']);
    Route::get('/assignment-history/{conversationId}', [AgentWhatsappController::class, 'getAssignmentHistory']);
    Route::get('/current-assignment/{conversationId}', [AgentWhatsappController::class, 'getCurrentAssignment']);
    Route::get('/client-orders/{clientId}', [AgentWhatsappController::class, 'getClientOrderHistory']);
});