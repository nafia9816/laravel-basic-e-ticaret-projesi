<?php

use App\Models\Ayar;

  if (! function_exists('get_ayar')) {//daha önce fonk adı kullanılmışmı kontrol ettik
  	
  	function get_ayar($anahtar){
  		$dakika=60;
  		$tumAyarlar=Cache::remember('tumAyarlar', $dakika, function(){
  			return Ayar::all();
  		});

  		return $tumAyarlar->where('anahtar',$anahtar)->first()->deger;
  	}
  }







?>