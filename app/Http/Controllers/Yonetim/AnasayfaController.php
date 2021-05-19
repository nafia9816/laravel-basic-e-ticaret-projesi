<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siparis;
use Illuminate\Support\Facades\Cache;

class AnasayfaController extends Controller
{
    public function index(){
/*
    	if(!Cache::has('istatistikler')){
    		$istatistikler=[
             'bekleyen_siparis'=> Siparis::where('durum','Siparişiniz Alındı')->count(),

    	     'tamamlanan_siparis'=> Siparis::where('durum','Siparişiniz Tamamlandı')->count()
    	];

    	$bitis_zamani=now()->addMinutes(10);//şuanki zamanın 10 dk sonrası
    	Cache::put('istatistikler',$istatistikler,$bitis_zamani);
    }else{
         $istatistikler=Cache::get('istatistikler');
    }
    */
    	
/*
    Cache::forget('istatistikler');//10 dk dan önce cach komutunu silmek istersek bunu kullanırız
    Cache::flush()//tüm cach deki veriker, siler.
*/      
        $cok_satan_urunler=DB::select("
              SELECT u.urun_adi, SUM(su.adet) adet
              FROM siparis siparis si
              INNER JOIN sepet s ON s.id = su.sepet_id
              INNER JOIN  urun u ON u.id = su.urun_id
              GROUP BY u.urun_adi
              ORDER BY SUM(su.adet) DESC

        	");
    	
    	return view('yonetim.anasayfa'/*, compact('istatistikler')*/, compact($cok_satan_urunler));


    }
}
