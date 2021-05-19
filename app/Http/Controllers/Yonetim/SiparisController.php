<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\UrunDetay;
use App\Models\Kategori;
use App\Models\Siparis;
class SiparisController extends Controller
{
     
    public function index(){
       

       //kullanıc ekleme sayfasındaki arama kısmı için
        if (request()->filled('aranan')) {
            request()->flash(); //session arasında sakladık
            $aranan=request('aranan');
            //bu şekilde with ile yapınca daha performanlı şekilde siparişin sepetine ve kullanıcısına a ulaşabildik bu yapıya eager loading denir. 
            //sadece where ile kullancakdık with kısmını hiç yazmadan yapsamda olur ama performansı düsük olur bu yapıya da lazy loading denir.
            $list=Siparis::with('sepet.kullanci')->where('adsoyad','like',"%$aranan%")
            ->orWhere('id',$aranan)
            ->orderByDesc('id')
            ->paginate(4)
            ->appends('aranan',$aranan);
        }else{
            $list=Siparis::orderByDesc('id')
        ->paginate(4);
        }

        

        return view('yonetim.siparis.index', compact('list'));
    }

    public function form($id=0){

       if ($id>0) { //kaydet me route tanımındada form fonksiyonunu kullandığım için eğer id varsa düzenle işlemi id yoksa da kaydetme işlemi yapacak diye ayırt ediyorum.
            $entry=Siparis::with('sepet.sepet_urunler.urun')
            ->find($id);
            //siparişle birlikte sepet urun değişkeni ve urunleri de çek
        }

        return view('yonetim.siparis.form', compact('entry'));

    }



    public function kaydet($id=0){
        
       $this->validate(request(), [
           'adsoyad' => 'required',
           'adres' => 'required',
           'telefon' => 'required',
            'durum' => 'required'
       ]);
       //formda gelen hangi bilgileri gücelemeye dahil etcem onları burada belirtirim
       $data=request()->only('adsoyad', 'adres','telefon','ceptelefonu','durum');

       if ($id>0) {
           //güncelleme işlemi
           $entry=Siparis::where('id' , $id)->firstOrFail();
           $entry->update($data); 
           

       }
       
       return redirect()->route('yonetim.siparis.duzenle',$entry->id)
       ->with('mesaj', 'güncellendi')
       ->with('mesaj_tur', 'success');
    }

    public function sil($id){

        Siparis::destroy($id); //direkt sil dedik
        

        return redirect()->route('yonetim.siparis')
            ->with('mesaj','kAYIT Silindi')
            ->with('mesaj_tur','success');
    }

   
}
