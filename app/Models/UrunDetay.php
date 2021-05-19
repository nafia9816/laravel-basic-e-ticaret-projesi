<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrunDetay extends Model
{   
	 protected $table="urun_detay";
     public $timestamps=false; //bu alanları kullanmadığımız için belirrtik.

     protected $guarded= [];
    //ürün eklerken detaylarının da eklenebilmesi için bunu koydık.
     


     public function  urun(){
 
        //urundetay modeli içinde ürüne ulaşmak için bunu yazarım.
        return $this->belongsTo('App\Models\Urun');

        //ürüne ait detayı çekebilmek için
    }
}
