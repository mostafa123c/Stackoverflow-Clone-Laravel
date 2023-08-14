<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Route;
use Symfony\Component\HttpFoundation\Response;
use URL;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $default = config('app.locale');
        $accept_language = $request->header('Accept-Language'); //browser language
        if($accept_language){
            list($default) = explode(',' , $accept_language);
        }

        $default = Session::get('locale' , $default);

        $lang = $request->query('lang' , $default);
        Session::put('locale' , $lang);

        App::setLocale($lang);

        //to make this stop the session and take lang from url
//        $lang = $request->route('lang' , $default);
//        App::setLocale($lang);
//        App::setLocale($lang);
//        URL::defaults(['lang' => $lang]);
//        Route::current()->forgetParameter('lang');


        return $next($request);
    }
}
