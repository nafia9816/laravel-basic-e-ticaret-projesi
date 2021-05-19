<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/','AnasayfaController@index')->name('anasayfa');
//artık sitemizin index.php sinde yani gogle açılan ilk sayfa anasayfa controller ın index metodunun içi oldun dedim. yani http://localhost/laravel/public/ yazınca index metodunun içi geliyor ekrana direkt:)

// route::view fonksiyonu: bir route adresi ile beraber doğrudan bir view dosyasını çıktı olarak kullanabilmeyi sağlar.
//Route::view('/kategori','kategori'); //kategori sayfasını açtığım zaman kategori sayfalarını açmayı sağlayacak root ttanımlarını yaptım.


Route::get('/kategori/{slug_kategoriadi}', 'KategoriController@index')->name('kategori');
//adres satırına kategori yazdıktan sonra bir parametre değeri ile beraber kategori adını göndermesini istiyorum.  bu adres satırına eriştiği andada bu kategori controllerının index metodunu çalıştırsın.


Route::get('/urun/{slug_urunadi}','UrunController@index')->name('urun');



Route::group(['prefix' =>'sepet'], function(){
    Route::get('/', 'SepetController@index')->name('sepet');
    Route::post('/ekle','SepetController@ekle')->name('sepet.ekle');
    // /ekle' bu kısımı sepet/ekle yazmaya gerek yok prefix olarak sepeti verdik zaten.
    // burada sepet.ekle name sini formun action kısmına verdik. urun viewında sepet ekle butonunun formunu actionuna :)

    Route::delete('/kaldir/{rowId}','SepetController@kaldir')->name('sepet.kaldir');
    //rowId: silinecek ürünün id si dir.

    Route::delete('/bosalt','SepetController@bosalt')->name('sepet.bosalt');

    Route::patch('/guncelle/{rowId}','SepetController@guncelle')->name('sepet.guncelle');
});


Route::get('/odeme','OdemeController@index')->name('odeme');
Route::post('/odeme','OdemeController@odemeyap')->name('odemeyap');

Route::group(['middleware' => 'auth'], function(){
    

     Route::get('/siparisler', 'SiparisController@index')->name('siparisler');

     Route::get('/siparisler/{id}','SiparisController@detay')->name('siparis');
});





//kullanıcının giriş yapması için gerekli root tanımlaması name deki . nın anlamı alt isim verebilmeyi sağlar
Route::get('/oturumac','KullaniciController@giris_form')->name('kullanici.oturumac');
Route::post('/oturumac','KullaniciController@giris')->name('kullanici.oturumac');





Route::get('/kaydol','KullaniciController@kaydol_form')->name('kullanici.kaydol');

Route::post('/kaydol','KullaniciController@kaydol')->name('kullanici.kaydol');
//formdan post la gelen veriler için birde post lu route oluşturduk

/* 
// eğer route ların ön kısmı aynıysa yani sabitse bu şekilde gruplandırma yapabiliriz.
Route::group(['prefix' =>'kullanici'], function(){
	Route::get('/oturumac','KullaniciController@giris_form')->name('kullanici.oturumac');

    Route::get('/kaydol','KullaniciController@kaydol_form')->name('kullanici.kaydol');
})

*/
Route::post('/ara', 'UrunController@ara')->name('urun_ara');
Route::get('/ara', 'UrunController@ara')->name('urun_ara');//bunun manası: sayfayı numaralandırdık listelemk için bir sonraki sayfalara gecince metodumuz post olduğu için hata alıyoruz. hata almadan gecmek için bir de get ini tanımladık

Route::get('/aktiflestir/{anahtar}','KullaniciController@aktiflestir')->name('aktiflestir');

Route::post('/oturumukapat','KullaniciController@oturumukapat')->name('kullanici.oturumukapat');



Route::group(['prefix' =>'yonetim', 'namespace' =>'Yonetim'], function(){//namespace tanımı ile demiş oldumki burada tanımlana kontrollerlar yönetim klasörünün içindeki kontrollar
     
     Route::redirect('/','/yonetim/oturumac');

     Route::match(['get','post'], '/oturumac' , 'KullaniciController@oturumac')->name('yonetim.oturumac');
     //match foksiyonu ile deddikki: bu routeyi get ile gelen metodlada post ile gelen metodlada yönlendirebilirsin

     Route::get('/oturumac', 'KullaniciController@oturumac')->name('yonetim.oturumac');
     
     Route::group(['middleware' => 'yonetim'],function(){
        Route::get('/anasayfa','AnasayfaController@index')->name('yonetim.anasayfa');

        Route::group(['prefix' => 'kullanici'], function(){
              
              Route::match(['get', 'post'],'/', 'KullaniciController@index')->name('yonetim.kullanici');

              Route::get('/yeni,' ,'KullaniciController@form')->name('yonetim.kullanici.yeni');

              Route::get('/duzenle/{id}', 'KullaniciController@form')->name('yonetim.kullanici.duzenle');

              Route::post('/duzenle/{id}', 'KullaniciController@form')->name('yonetim.kullanici.duzenle');

               Route::get('/kaydet/{id?}' ,'KullaniciController@kaydet')->name('yonetim.kullanici.kaydet');
               Route::post('/kaydet/{id?}' ,'KullaniciController@kaydet')->name('yonetim.kullanici.kaydet');


                Route::get('/sil/{id}' ,'KullaniciController@sil')->name('yonetim.kullanici.sil');
        });


        //kategori listeleme,silme vb. işlemleri için
        Route::group(['prefix' => 'kategori'], function(){
              
              Route::match(['get', 'post'],'/', 'KategoriController@index')->name('yonetim.kategori');

              Route::get('/yeni,' ,'KategoriController@form')->name('yonetim.kategori.yeni');

              Route::get('/duzenle/{id}', 'KategoriController@form')->name('yonetim.kategori.duzenle');

              Route::post('/duzenle/{id}', 'KategoriController@form')->name('yonetim.kategori.duzenle');

               Route::get('/kaydet/{id?}' ,'KategoriController@kaydet')->name('yonetim.kategori.kaydet');
               Route::post('/kaydet/{id?}' ,'KategoriController@kaydet')->name('yonetim.kategori.kaydet');


                Route::get('/sil/{id}' ,'KategoriController@sil')->name('yonetim.kategori.sil');
        });

        //ürün listeleme,silme vb. işlemleri için
        Route::group(['prefix' => 'urun'], function(){
              
              Route::match(['get', 'post'],'/', 'UrunController@index')->name('yonetim.urun');

              Route::get('/yeni,' ,'UrunController@form')->name('yonetim.urun.yeni');

              Route::get('/duzenle/{id}', 'UrunController@form')->name('yonetim.urun.duzenle');

              Route::post('/duzenle/{id}', 'UrunController@form')->name('yonetim.urun.duzenle');

               Route::get('/kaydet/{id?}' ,'UrunController@kaydet')->name('yonetim.urun.kaydet');
               Route::post('/kaydet/{id?}' ,'UrunController@kaydet')->name('yonetim.urun.kaydet');


                Route::get('/sil/{id}' ,'UrunController@sil')->name('yonetim.urun.sil');
        });
        

        //sipariş işlemleri için tanımlanan route ler
        Route::group(['prefix' => 'siparis'], function(){
              
              Route::match(['get', 'post'],'/', 'SiparisController@index')->name('yonetim.siparis');

              Route::get('/yeni,' ,'SiparisController@form')->name('yonetim.siparis.yeni');

              Route::get('/duzenle/{id}', 'SiparisController@form')->name('yonetim.siparis.duzenle');

              Route::post('/duzenle/{id}', 'SiparisController@form')->name('yonetim.siparis.duzenle');

               Route::get('/kaydet/{id?}' ,'SiparisController@kaydet')->name('yonetim.siparis.kaydet');
               Route::post('/kaydet/{id?}' ,'SiparisController@kaydet')->name('yonetim.siparis.kaydet');


                Route::get('/sil/{id}' ,'SiparisController@sil')->name('yonetim.siparis.sil');
        });



    });
     

    Route::get('/oturumukapat','KullaniciController@oturumukapat')->name('yonetim.oturumukapat');
});
















Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
