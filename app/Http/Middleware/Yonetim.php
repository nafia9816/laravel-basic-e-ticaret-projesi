<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Yonetim
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //yönetici anasayfayı açtığı anda neler oldun onu burada yapıyoruz.
        if (Auth::guard('yonetim')->check() && Auth::guard('yonetim')->user()->yonetici_mi) { //giren kullanıcının yoneticimi  değeri 1 mi

            return $next($request);//normal şekilde bu sayfayı aç
        }else{ //yönetici olmayanları oturum aç a yolladık.
            return redirect()->route('yonetim.oturumac');
        }
        
    }
}
