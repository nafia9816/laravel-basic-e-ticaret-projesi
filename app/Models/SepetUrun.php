<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SepetUrun extends Model
{
    protected $table="sepet_urun";
    protected $guarded=[];

    const CREATED_AT = 'olusma_tarihi';//tinker la tabloya veri eklerken created_at tanımı yok diyo bunun üönüne geçmek için burada belittim.
    const UPDATED_AT='guncellenme_tarihi';

    //protected $guarded=[]; //bu metodun içine mesela 'slug' ı yazarsam slug ı asla veritabanına değeri eklenmesin olarak ayarlarım. Ama boş bırakırsam ise tüm kolonlara değeri create metodula veritabanıa ekleyebilirim demiş olurum. bunu yaparsak fillable() a hiç gerek kalmaz.

    const DELETED_AT='silinme_tarihi';

//bu modelden ürün tablosunun bilgilerine erişebilmek için bunu yaxzarız
    public function urun(){
    	return $this->belongsTo('App\Models\Urun');
    }


}
