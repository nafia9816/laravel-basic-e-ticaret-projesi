<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use Hash;


class KullaniciController extends Controller
{
    public function oturumac(){
    	if (request()->isMethod('POST')) {//GELEN METHOD POST İSE
            
            //post ile formdan gelen verileri doğruladık.
    		$this->validate(request(), [
                'email' => 'required|email',
                'sifre' => 'required'
    		]);
            
            //girş ilemini yapıyoruz farklı bir teknikle:)
            $credentials=[
                 'email' =>request()->get('email'),
                 'password' =>request()->get('sifre'),
                 'yonetici_mi' => 1,
                 'aktif_mi' =>1
            ];
            //burada guard değerini yönetim olarak ayarlayarak müsteri arayüzünden bağımsız başka bir giriş yapmak istediğimi belittim.
    		if (Auth::guard('yonetim')->attempt($credentials, request()->has('benihatirla'))) {
    			return redirect()->route('yonetim.anasayfa');
    			//oturumu actığım anda yani giriş yapınca direkt anasayfaya gidelim
    		}else{
    			return back()->withInput()->withErrors(['email' => 'Giriiş Hatalı']);
    			//oturum ac a geri dön diyorum ama email ve  alanı dolu olarak dondurecek
    		}


    		
    	}
    	return view('yonetim.oturumac');
    }

    public function oturumukapat(){
    	 Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }


    public function index(){
       

       //kullanıc ekleme sayfasındaki arama kısmı için
        if (request()->filled('aranan')) {
            request()->flash(); //session arasında sakladık
            $aranan=request('aranan');
            $list=Kullanici::where('adsoyad','like',"%$aranan%")
            ->orWhere('email','like',"%$aranan%")
            ->orderByDesc('olusma_tarihi')
            ->paginate(4)
            ->appends('aranan',$aranan);
        }else{
            $list=Kullanici::orderByDesc('olusma_tarihi')
        ->paginate(4);
        }

        

        return view('yonetim.kullanici.index', compact('list'));
    }

    public function form($id=0){

        $entry=new Kullanici; //id gelmezse boş kullanıcı jaydı oluşturcak
        if ($id>0) { //kaydet me route tanımındada form fonksiyonunu kullandığım için eğer id varsa düzenle işlemi id yoksa da kaydetme işlemi yapacak diye ayırt ediyorum.
            $entry=Kullanici::find($id);
        }
        return view('yonetim.kullanici.form', compact('entry'));

    }

    public function kaydet($id=0){
       //formdan gelen bilgileri doğrulamişlemine sokuyorum

       $this->validate(request(), [
           'adsoyad' => 'required',
           'email' => 'required|email'
       ]);
        
       $data=request()->only('adsoyad', 'email');

//şifre alanın da güncellemeye dahil etmek için yazdık.
       if (request()->filled('sifre')) {
          $data['sifre']=Hash::make(request('sifre'));
       }

       if (request()->has('aktif_mi') && request('aktif_mi')==1) { //aktifmi seçilmişmi
           $data['aktif_mi'] =1;
       }else{
         $data['aktif_mi'] =0;
       }


        if (request()->has('yonetici_mi') && request('yonetici_mi')==1) { //aktifmi seçilmişmi
           $data['yonetici_mi'] =1;
       }else{
         $data['yonetici_mi'] =0;
       }




       if ($id>0) {
           //güncelleme işlemi
           $entry=Kullanici::where('id' , $id)->firstOrFail();
           $entry->update($data); 


       }else{
          $entry=Kullanici::create($data);
       }

           //KULLANICI DETAYTABLOSUNDAKİ VERİLERİ GÜNCELLEME
        KullaniciDetay::updateOrCreate(
            ['kullanici_id' => $entry->id], //eğer böyle bir kayıt varsa güncelliyo yoksa kullanıcı bu bilgileri kaydediyo
            ['adres' =>request('adres'),
             'telefon' =>request('telefon'),
             'ceptelefonu' =>request('ceptelefonu')
            ]
           );

       return redirect()->route('yonetim.kullanici.duzenle',$entry->id)
       ->with('mesaj', ($id>0 ? 'güncellendi' : 'kaydedildi'))
       ->with('mesaj_tur', 'success');
    }

    public function sil($id){
        Kullanici::destroy($id);

        return redirect()->route('yonetim.kullanici')
            ->with('mesaj','Kullanıcı Silindi')
            ->with('mesaj_tur','success');
    }
}
