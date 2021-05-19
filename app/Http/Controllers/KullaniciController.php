<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Kullanici;
use Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\KullaniciKayitMail;

use App\Models\Sepet;

use App\Models\SepetUrun;
use App\Models\KullaniciDetay;





class KullaniciController extends Controller
{   

    public function __construct(){
        $this->middleware('guest')->except('oturumukapat');
    }

    public function giris_form(){
    	return view('kullanici.oturumac');
    	//kullanıcı klasörünün içinde oturumac view ını açacak
    }

    public function giris(){
        $this->validate(request(), [
              'email' => 'required|email',
              'sifre' => 'required'
        ]);
        


        $credentials=[
           'email' => request('email'),
           'password' => request('sifre'),
           'aktif_mi' => 1
        ];
        if (auth()->attempt($credentials, request()->has('benihatirla'))) {
            
            request()->session()->regenerate();
            //if den başlayan ve buraya kadar olan kısım kulanıcı girş kısmınıy azdık.
             

             //kullanıcının sepeti hangi nolu id onu buluyoz kısaca
            $aktif_sepet_id=Sepet::aktif_sepet_id();
            if (!is_null($aktif_sepet_id)) { //null gelirse sepet
                $aktif_sepet=Sepet::create(['kullanici_id' =>auth()->id()]);
                $aktif_sepet_id=$aktif_sepet->id;
            }
            
            session()->put('aktif_sepet_id',$aktif_sepet_id);//sessionda bu id yi saklıyoruz. //kullanıcı giriş yaptığında sessiondaki ürünlerde veritabanına eklensin diye bı kodu yazıyoruz.


           //sessionda cart kutuphanesi kulllanılarak eklene veriler varsa bunları bulup db ye atıcaz(sepetürün tablosun a eklıycez)
            if (Cart::count()>0) {
                foreach (Cart::content() as $cartItem) {
                   SepetUrun::updateOrCreate(
                    ['sepet_id' =>$aktif_sepet_id, 'urun_id' =>$cartItem->id],

                    ['adet'=>$cartItem->qty, 'fiyati' =>$cartItem->price, 'durum' =>'Beklemede']

                   );
                }
            }

            Cart::destroy(); //daha sonta sessiondaki verileri siliyorum
            $sepetUrunler=SepetUrun::where('sepet_id',$aktif_sepet_id)->get();
            foreach ($sepetUrunler as $sepetUrun ){
               Cart::add($sepetUrun->urun->id, $sepetUrun->urun->urun_adi, $sepetUrun->adet,$sepetUrun->fiyati,['slug' => $sepetUrun->urun->slug]);

            }


            

            return redirect()->intended('/');


        }else{
            //kullanıcı girş yapamadığında burası çalışır. tekrar geiriş sayfasına geri gönderiyoruz
            $errors=['email' =>'Hatalı Giriş'];
            return back()->withErrors($errors);
        }
    }


    public function kaydol_form(){
        return view('kullanici.kaydol');
        
    }

    public function kaydol(){
        $this->validate(request(),[
            'adsoyad' => 'required|min:5|max:60',
            'email' =>'required|email|unique:kullanici',
            'sifre' =>'required|confirmed|min:5|max:15'
        ]);



    	$kullanici=Kullanici::create([
             'adsoyad' => request('adsoyad'),
             'email' =>   request('email'),
             'sifre' =>   Hash::make(request('sifre')),
             'aktivasyon_anahtari' => Str::random(60),//rastgele 60 karakterlik string oluştursun.
             'aktif_mi' => 0
        ]);

        $kullanici->detay()->save(new KullaniciDetay());
        //kullanıcıkaydoldyğu anda oto olarak bir kullanıcı detay kaydı oluşsacaktır. faakt boş olucak. burada kullanılan detay kullanıcı modelindeki fonk.

        Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));//kullanıcıya mail gönderdik

        auth()->login($kullanici); //model e gör eoto olarak giriş işlemini gerçekleştirdik.
    	return redirect()->route('anasayfa'); //anasayfa viewına yönlendşridm
    }


    public function aktiflestir($anahtar){
        $kullanici=Kullanici::where('aktivasyon_anahtari',$anahtar)->first();

        if (!is_null($kullanici)) {
            $kullanici->aktivasyon_anahtari=null;
            $kullanici->aktif_mi=1;
            $kullanici->save();

            return redirect()->to('/')
            ->with('mesaj' , 'Kullanıcı kaydınız aktifleştirildi')
            ->with('mesaj_tur', 'success');
            //redirect yerine burdada farklı yapı kullanarak ana sayfaya yönlendiridk
        }else{
             return redirect()->to('/')
            ->with('mesaj' , 'Kullanıcı kaydı bulunamadı')
            ->with('mesaj_tur', 'warning');
        }
    }

    public function oturumukapat(){
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('anasayfa');
    }
}
