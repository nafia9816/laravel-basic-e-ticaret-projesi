@extends('layouts.master')

@section('title','Sipariş Detayı')

@section('content')
  <div class="container">
        <div class="bg-content">
            <a href="{{ route('siparisler') }}" class="btn btn-xs btn-primary">Siparişlere dön</a>


            <h2>Sipariş (SP- {{ $siparis->id }})</h2>
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Tutar</th>
                    <th>Adet</th>
                    <th>Ara Toplam</th>
                    <th>Durum</th>
                </tr>
                
                @foreach($siparis->sepet->sepet_urunler as $sepet_urun)

                <tr>
                    <td style="width: 120px;"> <img src="img/2.jpg"></td>

                    <td>
                        <a href="{{ route('urun',$sepet_urun->urun->slug) }}">
                        {{ $sepet_urun->urun->urun_adi }}
                    </a></td>
                    <!-- sepet urun modelinin içindeki urun fonksiyonundn urun adını aldık-->
                    <td>{{ $sepet_urun->fiyati }}</td>
                    <td>{{ $sepet_urun->adet }}</td>
                    <td>{{ $sepet_urun->fiyati * $sepet_urun->adet }}</td>
                    <td>
                        {{ $sepet_urun->durum }}
                    </td>
                </tr>
                @endforeach
                <tr>
                   
                    <th colspan="4" class="text-right">Toplam Tutar </th>
                    <th colspan="2"> {{ $siparis->siparis_tutari }} </th>
                    <th></th>
                </tr>

                 <tr>
                   
                    <th colspan="4" class="text-right">Toplam Tutar (KDV dahil) </th>
                    <th colspan="2"> {{ $siparis->siparis_tutari * ((100+config('cart.tax'))/100) }} </th>
                    <th></th>
                </tr>


                 <tr>
                   
                    <th colspan="4" class="text-right">Sipariş Durumu </th>
                    <th colspan="2"> {{ $siparis->durum}} </th>
                    <th></th>
                </tr>
                

            </table>
        </div>
    </div>
@endsection()