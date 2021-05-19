<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Siparis;
use App\Models\Kullanici;
use App\Models\Urun;
use App\Models\Kategori;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        $bitis_zamani=now()->addMinutes(10);
        $istatistikler=Cache::remember('istatistikler', $bitis_zamani, function(){
             return [
                'bekleyen_siparis' => Siparis::where('durum','Siparişiniz Alındı')->count(),
                'tamamlanan_siparis' => Siparis::where('durum','Siparişiniz Tamamlandı')->count(),

                'toplam_urun'=> Urun::count(),
                'toplam_kategori'=> Kategori::count(),
                'toplam_kullanici' => Kullanici::count()

             ];
        });

        View::share('istatistikler',$istatistikler);
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
