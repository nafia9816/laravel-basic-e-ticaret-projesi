<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urun;

class UrunController extends Controller
{
    public function index($slug_urunadi){
         
        $urun=Urun::whereSlug($slug_urunadi)->firstOrFail();
        //urunun slug adına göre çekicek ya bir tane ürün döndürcek yada 404 hatası

        $kategoriler=$urun->kategoriler()->distinct()->get();
        //aynı kayıttan yani bir kayegoride aynı urunden iki tan varsa ekranda iki kez kategori adını yazmaması için teke düşürdük.
        // ürüne tıkladığında : Anasayfa  Elektronik elektronık  deterjan şeklinde ekranda çıkmasın diye.



    	return view('urun',compact('urun', 'kategoriler'));
    	//urun.blade.view a gönderiyoruz ürün değişkeninin içeriğini
    }

    public function ara(){
    	$aranan=request()->input('aranan');
    	$urunler=Urun::where('urun_adi', 'like' , "%$aranan%")//aranan kelimeyi bul
    	->orWhere('aciklama','like', "%$aranan%") //aynu zamanda acıklama içindee arana kelime geçiyorsa bul
    	->paginate(4); //bir sayfada kaç ürün listelensin bunu belirttim
    	//->get();//sayfalam yaptıktan sonra buna gerek yok.
    	//->simple paginate() dersem sayfalama linkleri numaralar gelmezde sadece ileri geri yazar.

    	request()->flash(); //bunun anlamı aranan kelimenin sessionda bir kere saklanmasını sağlar bunu navbar ın valuesinde yazıp bir sonraki istek ettiğim sayfada görünmesini sağlar. yani arama kısmında loyal aradım bir kez daha loyal arayınca loyal yazısı bir kereliğine mahsus orda görünür


    	return view('arama',compact('urunler'));
    }
}
