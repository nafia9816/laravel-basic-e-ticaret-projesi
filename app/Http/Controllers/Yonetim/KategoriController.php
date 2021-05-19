<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Kategori;

use Hash;


class KategoriController extends Controller
{

    public function index(){
       

       //kullanıc ekleme sayfasındaki arama kısmı için
        if (request()->filled('aranan') || request()->filled('ust_id')) {
            request()->flash(); //session arasında sakladık
            
            $aranan=request('aranan');
            $ust_id=request('ust_id');
            $list=Kategori::where('kategori_adi','like',"%$aranan%")
            ->where('ust_id','like', $ust_id)
            ->paginate(4)
            ->appends(['aranan' => $aranan, 'ust_id' => $ust_id]);
        }else{
          request()->flush();
            $list=Kategori::paginate(4);
        }

        $anakategoriler=Kategori::whereRaw('ust_id is null')->get();

        

        return view('yonetim.kategori.index', compact('list','anakategoriler'));
    }

    public function form($id=0){

        $entry=new Kategori; //id gelmezse boş kullanıcı jaydı oluşturcak
        if ($id>0) { //kaydet me route tanımındada form fonksiyonunu kullandığım için eğer id varsa düzenle işlemi id yoksa da kaydetme işlemi yapacak diye ayırt ediyorum.
            $entry=Kategori::find($id);
        }
        $kategoriler=Kategori::all();
        return view('yonetim.kategori.form', compact('entry','kategoriler'));

    }

    public function kaydet($id=0){
       //formdan gelen bilgileri doğrulamişlemine sokuyorum

       
        
       $data=request()->only('kategori_adi', 'slug','ust_id');
       if (!request()->filled('slug')) {
         $data['slug'] =str_slug(request('kategori_adi'));
         request()->merge(['slug' => $data['slug']]);
       }

       $this->validate(request(), [
           'kategori_adi' => 'required',
           'slug' => (request('original_slug') != request('slug') ? 'unique:kategori,slug' : '') 
       ]);






       if ($id>0) {
           //güncelleme işlemi
           $entry=Kategori::where('id' , $id)->firstOrFail();
           $entry->update($data); 


       }else{
          $entry=Kategori::create($data);
       }

       return redirect()->route('yonetim.kategori.duzenle',$entry->id)
       ->with('mesaj', ($id>0 ? 'güncellendi' : 'kaydedildi'))
       ->with('mesaj_tur', 'success');
    }

    public function sil($id){

        $kategori=Kategori::find($id);
        $kategori->urunler()->detach();
        $kategori->delete();

        return redirect()->route('yonetim.kategori')
            ->with('mesaj','Kullanıcı Silindi')
            ->with('mesaj_tur','success');
    }
}
