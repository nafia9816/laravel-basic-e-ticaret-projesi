

@extends('layouts.master')

@section('title',$urun->urun_adi)
@section('content')
   <div class="container">
        <ol class="breadcrumb">
            <li><a href="#">Anasayfa</a></li>
           <!-- urun modeli içine yazdığım kategoriler fonksiyonu çunku o fonksiyonun anlamı urune ait kategorileri çeçekn fonk. -->
            @foreach($kategoriler as $kategori) 
            <!-- ()->distinct()->get() burası: mesela aynı ürün aynı kategiri de 2 tane var buu teke düşürmek için yazıldı. view da bu tarz kodlamalar önerilmez o yuzden bunu controller içine alıcam-->
            <li><a href="{{ route('kategori',$kategori->slug) }}">
                {{ $kategori-> kategori_adi }}
            </a></li>
            @endforeach
            <li class="active"> {{ $urun->urun_adi }}</li>
        </ol>
        <div class="bg-content">
            <div class="row">
                <div class="col-md-5">
                    <img src="img/25.jpg">
                    <hr>
                    <div class="row">
                        <div class="col-xs-3">
                            <a href="#" class="thumbnail"><img src="img/25.jpg"></a>
                        </div>
                        <div class="col-xs-3">
                            <a href="#" class="thumbnail"><img src="img/25.jpg"></a>
                        </div>
                        <div class="col-xs-3">
                            <a href="#" class="thumbnail"><img src="img/25.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <h1>{{ $urun->urun_adi }}</h1>
                    <p class="price">{{ $urun->fiyati }} ₺</p>

                    <form action="{{ route('sepet.ekle') }}" method="post">
                        {{ csrf_field() }}
                        <!-- form ile veri gönderebilmek için bu alanı tanımlamamız gerek -->
                        <input type="hidden" name="id" value="{{ $urun->id }}">
                        <input type="submit" class="btn btn-theme" value="Sepete Ekle">
                        <!-- sepete ekle butonuna basınca bunu seper.ekle routesine gondercek -->
                    </form>
                    <!--
                    <p><a href="#" class="btn btn-theme">Sepete Ekle</a></p>  bu kısmı silip yukarıdaki formu olşturduk
                -->
                </div>
            </div>

            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#t1" data-toggle="tab">Ürün Açıklaması</a></li>
                    <li role="presentation"><a href="#t2" data-toggle="tab">Yorumlar</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="t1">
                        {{ $urun->aciklama }}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="t2">Henüz yorum yapılmadı</div>

                    <br> <br> <br>
                </div>
            </div>

        </div>
    </div>

@endsection


