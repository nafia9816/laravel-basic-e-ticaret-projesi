<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kategori')->truncate();
        //truncate çalışınca tablodaki tüm verileri siler.

        $id=DB::table('kategori')->insertGetId(['kategori_adi' =>'Kahve', 'slug' =>'kahve']);
        DB::table('kategori')->insert(['kategori_adi'=>'MutluMod','slug'=>'mutlumod', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'HüzünMod','slug'=>'hüzünmod', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'MixMod','slug'=>'mixmod', 'ust_id'=>$id]);


        $id=DB::table('kategori')->insertGetId(['kategori_adi' =>'Kitap', 'slug' =>'kitap']);
        DB::table('kategori')->insert(['kategori_adi'=>'Roman','slug'=>'roman', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Tarihi','slug'=>'tarihi', 'ust_id'=>$id]);


        $id=DB::table('kategori')->insertGetId(['kategori_adi' =>'Yemek', 'slug' =>'yemek']);
        DB::table('kategori')->insert(['kategori_adi'=>'Fastfood','slug'=>'fastfood', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Sağlıklı','slug'=>'sağlıklı', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=>'Tatlı','slug'=>'tatlı', 'ust_id'=>$id]);


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        
    }
}
