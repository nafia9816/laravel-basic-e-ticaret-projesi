<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siparis;


class SiparisController extends Controller
{
    public function index(){

    	$siparisler=Siparis::with('sepet')
        ->whereHas('sepet', function($query){
            $query->where('kullanici_id', auth()->id());
        })


        ->orderByDesc('olusma_tarihi')->get(); //sipariş tablosundan tüm kayıtları cektim ve siparisler viewına yolladım.
    	//siparişlerle beraber eager loding yapısı sayesinde sepet bilgisinide çekmiş olacaz
    	return view('siparisler',compact('siparisler'));
    }

    public function detay($id){
    	$siparis=Siparis::with('sepet.sepet_urunler.urun')
        ->whereHas('sepet', function($query){
            $query->where('kullanici_id', auth()->id());
        })


        ->where('siparis.id',$id)->firstOrFail();
    	//sipariş tablosundan cektiği siparişle birliklte sepet ten ürünleri de çekmesi için yazdım. 
    	return view('siparis',compact('siparis'));
    }
}
