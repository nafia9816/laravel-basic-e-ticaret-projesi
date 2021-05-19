<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Kullanici extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $table='kullanici';

    

    protected $fillable = [
        'adsoyad', 'email', 'sifre','aktivasyon_anahtari','aktif_mi','yonetici_mi'
    ];//bu alanlar doldurulsun dedik

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'sifre', 'aktivasyon_anahtari',
        //sorgularda bunlar çekilmesin/görünmesin
    ];

    const CREATED_AT = 'olusma_tarihi';//tinker la tabloya veri eklerken created_at tanımı yok diyo bunun üönüne geçmek için burada belittim.
    const UPDATED_AT='guncellenme_tarihi';

    //protected $guarded=[]; //bu metodun içine mesela 'slug' ı yazarsam slug ı asla veritabanına değeri eklenmesin olarak ayarlarım. Ama boş bırakırsam ise tüm kolonlara değeri create metodula veritabanıa ekleyebilirim demiş olurum. bunu yaparsak fillable() a hiç gerek kalmaz.

    const DELETED_AT='silinme_tarihi';

    public function getAuthPassword(){
        return $this->sifre;
    }

    public function detay(){
        return $this->hasOne('App\Models\KullaniciDetay')
        ->withDefault(); //detay bilgisi yoksa varsayılan olarak modelle doldurmasını sağlamak için

        //bir kullanıcıya ait sadece bir kullanıcı detaı vardır.
    }
}
