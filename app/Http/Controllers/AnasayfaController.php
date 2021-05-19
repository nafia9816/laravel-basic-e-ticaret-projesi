<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\UrunDetay;
use App\Models\Urun;

class AnasayfaController extends Controller
{
    public function index(){

    	$kategoriler=Kategori::whereRaw('ust_id is null')->get();//kategori model sınıfını burada kullanabilmek için yukarıda use ile sayfada tanıttım.

    	//$kategoriler=Kategori::all()->take(3); //take ile demiş oldum ki sadece 3 kaydı çek

    	$urunler_slider=UrunDetay::with('urun')->where('goster_slider',1)->take(get_ayar('anasayfa_slider_urun_adet'))->get();
    	//with ile iki sorguyu bir satırda fazla kod yazmadan çekmiş olduk. 


    	$urun_gunun_firsati=Urun::select('urun.*')//urun tablosundaki tüm kolonları çek dedim
    	    ->join('urun_detay','urun_detay.urun_id','urun.id')//join ile bir modele başka bir tabloyu bağlayarak verilerin çekilmesini sağlayabiliriz.
    	    ->where('urun_detay.goster_gunun_firsati',1) //veritabanındaki urudetay tablounda gunun firsatı bir olanları çek
    	    ->orderBy('guncellenme_tarihi','desc') //en yeni den eskiye sırala
    	    ->first(); //ve sıralamanın en başındakini yani en yeni olan ürünü ver:)

    	    //veritabanında istediğim ürünü çektim ve ekranda çıktılanması için view a gönderdim.


//bu sorgulaıda yukarıdaki gibi en yeni ürünü secebilsin
    	 $urunler_one_cikan=UrunDetay::with('urun')->where('goster_one_cikanlar',1)->take(get_ayar('anasayfa_liste_urun_adet'))->get();
    	 $urunler_cok_satan=UrunDetay::with('urun')->where('goster_cok_satanlar',1)->take(get_ayar('anasayfa_liste_urun_adet'))->get();
    	 $urunler_indirimli=UrunDetay::with('urun')->where('goster_indirimli',1)->take(get_ayar('anasayfa_liste_urun_adet'))->get();

    	
    	return view('anasayfa',compact('kategoriler','urunler_slider','urun_gunun_firsati','urunler_one_cikan','urunler_cok_satan','urunler_indirimli'));
    	//kategori modelinde tüm kategorileri çektik ve anasayfa viewına yolladık.


    }
}
