<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\UrunDetay;
use App\Models\Kategori;
class UrunController extends Controller
{
     
    public function index(){
       

       //kullanıc ekleme sayfasındaki arama kısmı için
        if (request()->filled('aranan')) {
            request()->flash(); //session arasında sakladık
            $aranan=request('aranan');
            $list=Urun::where('urun_adi','like',"%$aranan%")
            ->orWhere('aciklama','like',"%$aranan%")
            ->orderByDesc('olusma_tarihi')
            ->paginate(4)
            ->appends('aranan',$aranan);
        }else{
            $list=Urun::orderByDesc('olusma_tarihi')
        ->paginate(4);
        }

        

        return view('yonetim.urun.index', compact('list'));
    }

    public function form($id=0){

        $entry=new Urun; //id gelmezse boş ürün jaydı oluşturcak
        $urun_kategorileri=[]; //birden fazla kategori seçerken seçilenleri gosterme si için

        if ($id>0) { //kaydet me route tanımındada form fonksiyonunu kullandığım için eğer id varsa düzenle işlemi id yoksa da kaydetme işlemi yapacak diye ayırt ediyorum.
            $entry=Urun::find($id);
            $urun_kategorileri=$entry->kategoriler()->pluck('kategori_id')->all(); //kategorilerin belli kolonunu çekerken buradaki gibi sadece id sini çekerken pluck fonk. u kullanırız.

        }

        $kategoriler=Kategori::all();
        return view('yonetim.urun.form', compact('entry','kategoriler', 'urun_kategorileri'));

    }

    public function kaydet($id=0){
        
       $data=request()->only('urun_adi', 'slug','aciklama','fiyati');
       if (!request()->filled('slug')) {
         $data['slug'] =str_slug(request('urun_adi'));
         request()->merge(['slug' => $data['slug']]);
       }

       $this->validate(request(), [
           'urun_adi' => 'required',
           'fiyati' => 'required',
           'slug' => (request('original_slug') != request('slug') ? 'unique:urun,slug' : '') 
       ]);

       $data_detay=request()->only('goster_slider','goster_gunun_firsati', 'goster_one_cikanlar', 'goster_cok_satanlar', 'goster_indirimli','urun_resmi');

       $kategoriler=request('kategoriler');//birden fazla kategoi seçmek için formda kullandığım değişken

       if ($id>0) {
           //güncelleme işlemi
           $entry=Urun::where('id' , $id)->firstOrFail();
           $entry->update($data); 
            
            //goster slider vb. onları güncellemek için burayı yazaroz
            $entry->detay()->update($data_detay);
            $entry->kategoriler()->sync($kategoriler);//birden fazla kategoriyi  ürün güncelleme esnasında eklemek için 




       }else{//ürün ekleme kısmı
          $entry=Urun::create($data);
          $entry->detay()->create($data_detay);
          //birden fazla kategoriyi yeni ürün eklerken aşağıdaki gib ekleriz
          $entry->kategoriler()->attach($kategoriler);
       }

       //RESİM YÜKLEME 
       if (request()->hasFile('urun_resmi')) {
        /* $this->validate(request(), [
              'urun_resmi' => 'image|mimes:jpg,png,jpeg,gif'
         ]);*/

          $urun_resmi=request()->file('urun_resmi');//resme ait bilgileri çektik
         //$urun_resmi=request()->urun_resmi;

          $dosyaadi=$entry->id . "-" . time() . $urun_resmi->extension();

          if ($urun_resmi->isValid()) {
            $urun_resmi->move('uploads/urunler', $dosyaadi);
           //belirlediğimiz klasöre upload etmiş oluruz.

            UrunDetay::updateOrCreate(
               ['urun_id' => $entry->id],
               ['urun_resmi' => $dosyaadi]
          );
         }

       }

       return redirect()->route('yonetim.urun.duzenle',$entry->id)
       ->with('mesaj', ($id>0 ? 'güncellendi' : 'kaydedildi'))
       ->with('mesaj_tur', 'success');
    }

    public function sil($id){

        $urun=Urun::find($id); //ürünü bul
        $urun->kategoriler()->detach(); //çoka çok ilişkide olan ürünleri silerken bu fonk. u kulanırız. ani ürün silinirse ürün detaytablosundan da silinsin diye (urunun kategorilerini sil)
        $urun->detay()->delete(); //ürün detay tablosundan ürünü silerken arasında bire bir ilişki old.için delete yi kullandık(urunun detayını sil)
        $urun->delete(); //ürünun kendisi sil

        return redirect()->route('yonetim.urun')
            ->with('mesaj','Ürün Silindi')
            ->with('mesaj_tur','success');
    }

   
}
