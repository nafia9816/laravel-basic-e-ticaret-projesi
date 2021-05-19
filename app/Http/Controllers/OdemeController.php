<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\Siparis;
use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\KullaniciDetay;

class OdemeController extends Controller
{
    public function index(){
       
    	if (!auth()->check()) {//route tanımında odeme routesini auth middle ware den çıkarıp burada oturum açıp açmadığını kontrol ettim
    		return redirect()->route('kullanici.oturumac')
    		->with('mesaj_tur','info')
    		->with('mesaj' , 'Ödeme işlemi yapmak için oturum açmalısınız.');
    	}else if(count(Cart::content())==0){ //bu komut ile sepet içindeki tüm ürünleri çekerim
    		return redirect()->route('anasayfa')
    		->with('mesaj_tur','info')
    		->with('mesaj' , 'Ödeme işlemi için sepetinizinde ürün bulunmalıdır.');
    	}

    	$kullanici_detay=auth()->user()->detay;//giriş yapan kullanıcının kullanıc deay tabosundaki detay fonk. u sayesinde oto olarak çektim. ve ödeme viewına gönderiyorum. ödeme sayfasında bu bilgileri oto olarak çekicem(odeme viewında inputların valur kısmını yazarak)



    	return view('odeme',compact('kullanici_detay'));
    }


    public function odemeyap(){
    	$siparis=request()->all(); //formdan gelen tüm bilgileri çektik
         
         //sipariş dısındaki ekxta bilgileri ise kodla oluşturuyorumö.
    	$siparis['sepet_id']=session('aktif_sepet_id');//sepetin id sini aldık.

    	$siparis['banka'] ="Garanti";
    	$siparis['taksit_sayisi'] = 1;
    	$siparis['durum']='Siparişiniz Alındı.';
    	$siparis['siparis_tutari']=Cart::subtotal(); //kdv siz fiyatı almak için subtotl kullandım.

    	Siparis::create($siparis); //sipariş ile yukarıda aldığım bilgileri bu kodla veritabanına atmış oldum.

    	Cart::destroy(); //sepeti temizlıyorum siparş kaydında sonra 
    	session()->forget('aktif_sepet_id'); //sonrada session içindeki sepet id yide siliyorum

    	return redirect()->route('siparisler')
    	->with('mesaj_tur', 'success')
    	->with('mesaj', 'Ödemeniz gerçekleştirildi.');




    }
}
