<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index($slug_kategoriadi){
    	$kategori=Kategori::where('slug',$slug_kategoriadi)->firstOrFail();
    	//bir tane değer bul bulamazsan 404 hatası dönercek.

    	$alt_kategoriler=Kategori::where('ust_id',$kategori->id)->get();

    	//$urunler=$kategori->urunler()->paginate(2);//bir kategorideki ürünlerin hesini almı olduk bu ürünleride compact ile dizi halinde view a yolladık.

        $order=request('order');
        if ($order =='coksatanlar') {
        	$urunler=$kategori->urunler()
        	->distinct()
        	->join('urun_detay','urun_detay.urun_id', 'urun.id')
        	->orderBy('urun_detay.goster_cok_satanlar','desc')
        	->paginate(2);
        }elseif($order =='yeni'){
             $urunler=$kategori->urunler()
            ->distinct()
        	->orderBy('guncellenme_tarihi','desc')
        	->paginate(2);
        }else{
             $urunler=$kategori->urunler()->paginate(2);
        }


    	return view('kategori', compact('kategori','alt_kategoriler' , 'urunler'));
    }
}
