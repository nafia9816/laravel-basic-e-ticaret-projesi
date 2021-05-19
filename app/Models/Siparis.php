<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siparis extends Model
{
    protected $table="siparis";

    protected $fillable=['sepet_id','siparis_tutari','adsoyad','adres','telefon','ceptelefonu','banka','taksit_sayisi','durum']; 

    //burayı guarded tanımlamıstım. odeme sayfasında bilgileri doldurdum ödeme yap basıyorum kart_no da sonkullnma tarihi ay vb. de bilinmeyen kolon falan hatasıverdi. nedeni burayı guarded yaptığım için illa veritabanında kartno kolonu falan da olmalı dedi.

    const CREATED_AT = 'olusma_tarihi';//tinker la tabloya veri eklerken created_at tanımı yok diyo bunun üönüne geçmek için burada belittim.
    const UPDATED_AT='guncellenme_tarihi';

    //protected $guarded=[]; //bu metodun içine mesela 'slug' ı yazarsam slug ı asla veritabanına değeri eklenmesin olarak ayarlarım. Ama boş bırakırsam ise tüm kolonlara değeri create metodula veritabanıa ekleyebilirim demiş olurum. bunu yaparsak fillable() a hiç gerek kalmaz.

    const DELETED_AT='silinme_tarihi';

//bu tablo dan doğrudan sepet tablosuna ulaşmış olduk. hani siparis->sepet->adi diyoruz ya bu fonk. sayesinde
    public function sepet(){
    	return $this->belongsTo('App\Models\Sepet');
    }
}
