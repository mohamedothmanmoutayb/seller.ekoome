<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Lead;
use App\Models\Countrie;
use App\Models\Notification;
use App\Models\Subscription;
use App\Observers\LeadObserver;
use App\Observers\SubscriptionObserver;
use App\Services\UsageTrackingService;
use Auth;
use Illuminate\Support\Facades\Storage;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {//dd(Auth::check());
        Lead::observe(LeadObserver::class);
        Subscription::observe(SubscriptionObserver::class);
        view()->composer('*', function ($view)
        {
        //     if(Auth::user()){

        //         $currency = Countrie::where('id', Auth::user()->country_id)->first();
        //         $countri = Countrie::where('id',Auth::user()->country_id)->first();

        //     $view->with(['countri' => $countri , 'currency' => $currency  ]);
                
        //     }
        // });
        // $this->loadGoogleStorageDriver();

          if (Auth::check()) {
            $user = Auth::user();

            $currency = Countrie::where('id', $user->country_id)->first();
            $countri = Countrie::where('id', $user->country_id)->first();
            // $allnotifications = Notification::where('user_id', $user->id)
            //     ->orderBy('created_at', 'desc')
            //     ->get();
            
            $notifications = Notification::where('user_id', $user->id_role)
                ->where('is_read', false)
                ->orderBy('created_at', 'desc')
                ->take(100)
                ->get();    

            $view->with([
                'countri' => $countri,
                'currency' => $currency,
                'notifications' => $notifications,
                //  'allnotifications' => $allnotifications
            ]);
        } else {
            $view->with([
                'notifications' => collect()
            ]);
        }
    });

    $this->loadGoogleStorageDriver();
}
    
    private function loadGoogleStorageDriver(string $driverName = 'google') {
        try {
            Storage::extend($driverName, function($app, $config) {
                $options = [];
    
                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }
    
                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);
    
                $service = new \Google\Service\Drive($client);
                $adapter = new  \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);
    
                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch(Exception $e) {
            // your exception handling logic
        }
    }
}
