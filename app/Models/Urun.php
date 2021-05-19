<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urun extends Model
{
    //use SoftDeletes;

    protected $table="urun";
     //bu tanımlamayı yapmamızın sebebi; conso lüzerinden eloquent orm yapısıyla tablodan verileri çekmek istediğimizde laravel uruns diye s takılı oluşturduğu için hata alıyoruz. Oyuzden burada özellikle tablo adını belittik.

   // protected $guarded=[]; //bu metodun içine mesela 'slug' ı yazarsam slug ı asla veritabanına değeri eklenmesin olarak ayarlarım. Ama boş bırakırsam ise tüm kolonlara değeri create metodula veritabanıa ekleyebilirim demiş olurum. bunu yaparsak fillable() a hiç gerek kalmaz.
    protected $fillable = [
        'urun_adi', 'slug', 'aciklama','fiyati'
    ];

    const CREATED_AT = 'olusma_tarihi';//tinker la tabloya veri eklerken created_at tanımı yok diyo bunun üönüne geçmek için burada belittim.
    const UPDATED_AT='guncellenme_tarihi';

   
   //bu fonksiyon ile doğrudan veri çekme işlemini gerçekleştiricem yani bir kategorideki tüm ürünleri çekmeme yarıyor.
    const DELETED_AT='silinme_tarihi';

    public function kategoriler(){
    	return  $this->belongsToMany('App\Models\Kategori', 'kategori_urun');
    }

    public function detay(){
        return $this->hasOne('App\Models\UrunDetay')->withDefault();
        //with defaul olmasaydı yenieklediğimiz ürünün detaını çalıştırınca hata olurdu non object diye

        //ürüne ait detayı çekebilmek için
    }


}
