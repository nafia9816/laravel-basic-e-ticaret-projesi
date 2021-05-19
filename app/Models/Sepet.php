<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class Sepet extends Model
{
    protected $table="sepet";

    protected $guarded = [];  //tüm alanları eklenebilir olark ayarladım

    const CREATED_AT = 'olusma_tarihi';//tinker la tabloya veri eklerken created_at tanımı yok diyo bunun üönüne geçmek için burada belittim.
    const UPDATED_AT='guncellenme_tarihi';

    //protected $guarded=[]; //bu metodun içine mesela 'slug' ı yazarsam slug ı asla veritabanına değeri eklenmesin olarak ayarlarım. Ama boş bırakırsam ise tüm kolonlara değeri create metodula veritabanıa ekleyebilirim demiş olurum. bunu yaparsak fillable() a hiç gerek kalmaz.

    const DELETED_AT='silinme_tarihi';

//sipariş tablosuna bu tablodan ulaşabilmek için yazdım.
    public function siparis(){
    	return $this->hasOne('App\Models\Siparis');
    }

    public function sepet_urunler(){
    	return $this->hasMany('App\Models\Sepeturun');
    }



    public static function aktif_sepet_id(){
    	$aktif_sepet=DB::table('sepet as s') //sepet tablosunda sor yapacağımızı soyledik ve s adında alias verdik
    	->leftJoin('siparis as si','si.sepet_id' , '=' , 's.id') //sipariş tablosuyla ilişki kurmasını sağladım. vesiparis tablosundaki sepet id ile sepet tablosundaki id nin ikişkili olduğunu belirttik
    	->where('s.kullanici_id',auth()->id()) // sepet ve siparişten verileri cektikten sonra bu kayıtlar içinden sadece kullanıc girişşi yapanların kayıtlarını al dedik
    	->whereRaw('si.id is null')//sepete ait sipariş yoksa bu is boş gelecek. bu komutla sipariş id si null olan kayıtı bukduk
    	->orderByDesc('s.olusma_tarihi') //
    	->select('s.id')
    	->first();

    	if (!is_null($aktif_sepet)) return $aktif_sepet->id;
    }

    public function sepet_urun_adet(){
    	return DB::table('sepet_urun')->where('sepet_id',$this->id)->sum('adet');

    	//aktif sepet id si hangisi ise o sepete ait ürünleri sun metoduyla topluyoruz


    }

    public function kullanici(){
        return $this->belongsTo('App\Models\Kullanici');
    }

}
