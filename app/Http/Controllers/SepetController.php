<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\Urun;
use App\Models\Sepet;
use App\Models\SepetUrun;
use Validator;

class SepetController extends Controller
{
    public function index(){
    	return view('sepet');
    }


    public function ekle(){
    	$urun=Urun::find(request('id'));
    	$cartItem=Cart::add($urun->id, $urun->urun_adi, 1 , $urun->fiyati,['slug' =>$urun->slug]);
    	//yüklediğimiz library ı kullanarak sepete ürünekledik

      if (auth()->check()) { //bu fonk: kullanıcı eğer giriş yaptıysa manasına gelir.
        $aktif_sepet_id=session('aktif_sepet_id'); //sepet kaydı oluşturduk.
        if (!isset($aktif_sepet_id)) {
          $aktif_sepet=Sepet::create([
          'kullanici_id'=> auth()->id() //kullanıcı girişi yapan kullanıcının id sini akdık.
        ]);
        
        
        $aktif_sepet_id= $aktif_sepet->id;
        session()->put('aktif_sepet_id',$aktif_sepet_id);
        //sepet id yi sessionda da tutalım.
       }

       SepetUrun::updateOrCreate(
         ['sepet_id' => $aktif_sepet_id, 'urun_id' =>$urun->id],
         ['adet' =>$cartItem->qty, 'fiyati' =>$urun->fiyati, 'durum' =>'Beklemede']
       );


      }



    	return redirect()->route('sepet')
    	->with('mesaj_tur','success')
    	->with('mesaj','Ürün sepete eklendi');

    }

    public function kaldir($rowid){

      //sepetten ürün kaldırınca veritabanından kaırdın diye bu if bloğunu yazdık.
       if (auth()->check()) {
         $aktif_sepet_id=session('aktif_sepet_id');
         $cartItem=Cart::get($rowid);
         SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->id)->Delete();
       }



       Cart::remove($rowid);
       
       return redirect()->route('sepet')
       ->with('mesaj_tur' ,'success')
       ->with('mesaj','Ürün sepetten kaldırıldı.');
    }

    public function bosalt(){
      //veritabanından da sepet boşalsın diye bu if blogunu yazdık.
      if (auth()->check()) {
         $aktif_sepet_id=session('aktif_sepet_id');
        
         SepetUrun::where('sepet_id', $aktif_sepet_id)->Delete();
       }



    	Cart::destroy();

    	 return redirect()->route('sepet')
       ->with('mesaj_tur' ,'success')
       ->with('mesaj','Ürün sepetiniz boşaltıldı.');
    }

    public function guncelle($rowid){
      
      $validator=Validator::make(request()->all(), [
          'adet' =>'required|numaric|between:1,5'
      ]);
      if ($validator->fails()) {
        session()->flash('mesaj_tur','danger');
        session()->flash('mesaj','Adet değeri 1 ile 5 arasında olmalı.');

        return response()->json(['success' =>false]);
      }

//veritabanında da güncellemeler yansısın diye. yazdık.
       if (auth()->check()) {
         $aktif_sepet_id=session('aktif_sepet_id');
         $cartItem=Cart::get($rowid);

         if (request('adet') ==0) {
           SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->id)->delete();
         }else{
           SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->id)->update(['adet' =>request('adet')]);
         }
        
       }



    	Cart::update($rowid, request('adet'));

    	session()->flash('mesaj_tur','success');
    	session()->flash('mesaj','Adet bilginiz güncellendi');

    	return response()->json(['success' =>true]);

    }
















}
