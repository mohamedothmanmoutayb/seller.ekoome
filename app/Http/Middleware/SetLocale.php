<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $userPhone = str_replace("whatsapp:", "", $request->input('From'));
        $session = Session::where('phone', $userPhone)->first();

        if ($session && $session->language) {
            App::setLocale($session->language);
        } else {
            // Set a default locale if no session or language is found
            App::setLocale(config('app.locale')); // Or 'en'
        }

        return $next($request);
    }
}
