<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes; //artık bu model soft deleting yapısıyla çalışacaktır. yani bir sey silindiği anda veritabanına bu kolonda tarihini yazacak.

class Kategori extends Model
{
	

    protected $table='kategori';

    protected $fillable=['kategori_adi','slug'];//CMD ÜZERİNDEN TİNKER LA KATEGORİ TABLOSUNA VERİ EKLERKEN GUVENLİK GEREĞİ KAtegori_adi ni kullanmaya izin veredi onun için bunu yazdım. 

    const CREATED_AT = 'olusma_tarihi';//tinker la tabloya veri eklerken created_at tanımı yok diyo bunun üönüne geçmek için burada belittim.
    const UPDATED_AT='guncellenme_tarihi';

    //protected $guarded=[]; //bu metodun içine mesela 'slug' ı yazarsam slug ı asla veritabanına değeri eklenmesin olarak ayarlarım. Ama boş bırakırsam ise tüm kolonlara değeri create metodula veritabanıa ekleyebilirim demiş olurum. bunu yaparsak fillable() a hiç gerek kalmaz.

    const DELETED_AT='silinme_tarihi';


    //bu fonksiyon ile doğrudan veri çekme işlemini gerçekleştiricem yani bir kategorideki tüm ürünleri çekmeme yarıyor.
    public function urunler(){
    	return  $this->belongsToMany('App\Models\Urun', 'kategori_urun');
    }


    public function ust_kategori(){
        return $this->belongsTo('App\Models\Kategori','ust_id')
        ->withDefault([
            'kategori_adi' =>'Ana Kategori'

        ]);
    }
}
