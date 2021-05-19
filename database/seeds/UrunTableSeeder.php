<?php

use Illuminate\Database\Seeder;
use App\Models\UrunDetay;
use App\Models\Urun;

class UrunTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {   

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //CMD DE SSEDI ÇALIŞtırıken hata aldım foreign key le alakalı o yuzden yazduım en sondada actık

        Urun::truncate();
        UrunDetay::truncate();

        //30 tane ürünü faker sayesinde hızlıca ekledik.
        for($i=0; $i<30 ; $i++){
        	$urun_adi=$faker->sentence(2);
        	$urun=Urun::create([
               'urun_adi' =>$urun_adi,
               'slug'=>str_slug($urun_adi),
               'aciklama'=>$faker->sentence(5),
               'fiyati'=>$faker->randomFloat(3,1,20)//1 20 arası 3 basamaklı float sayi üret
        	]);

          $detay=$urun->detay()->create([
               'goster_slider' =>rand(0,1),
               'goster_gunun_firsati' =>rand(0,1),
               'goster_one_cikanlar'=>rand(0,1),
               'goster_cok_satanlar'=>rand(0,1),
               'goster_indirimli'=>rand(0,1),
               'urun_resmi' => 'SomeRandomString' 


          ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    }

}
