<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ust_id')->nullable();
            $table->string('kategori_adi',50);
            $table->string('slug',40);
            //$table->timestamps(); //tabloda laravelin oto olrak anımladığı created_date(kaydın oluşma tarihi) ve updated_date( kaydın güncellenme tarihi) kolonlarının olmasını istediğim için bunu silmedim. $table=timestamp('olusma_tarihi') seklinde istersek türkçe tanımlayabiliriz.

            $table->timestamp('olusma_tarihi')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamp('guncellenme_tarihi')->default(DB::raw('CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP'));

           // $table->softDeletes();//burası tabloda deleted_at kolonunu oluşturur.
            

            //deleted_at olan silinme tarihini türkçeleştirdim. ve modelde tanımladımkı çalışma esnsında laravelkendi değişken adı olan deleted_at i aramasın
            $table->timestamp('silinme_tarihi')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori');
    }
}
