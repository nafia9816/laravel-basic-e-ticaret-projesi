@extends('yonetim.layouts.master')
@section('title', 'Sipariş Yönetimi')

@section('content')
  <br>
   <h1 class="page-header">Sipariş Yönetimi</h1>
                <form method="post" action="{{ route('yonetim.siparis.kaydet', @$entry->id) }}" >
            {{ csrf_field() }}

                    <div class="pull-right">
                    	<button type="submit" class="btn btn-warning">
                    		{{ @$entry->id > 0 ? "Güncelle" : "Kaydet" }}
                    	</button>
                    </div>
                    <h2 class="sub-header">
                    	Sipariş {{ @$entry->id > 0 ? "Düzenle" : "Ekle" }}
                    </h2>
                    @include('layouts.partials.errors')
                    @include('layouts.partials.alert')
               
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="adsoyad">Adı Soyadı</label>
                                <input type="text" class="form-control" id="adsoyad" placeholder="Adı Soyadı" name="adsoyad" value="{{ old('adsoyad',$entry->adsoyad) }}">
                                <!-- formda hata olduğunda eski bilgiyi l eski bilgi >yoksa db deki bilgiyi al -->
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefon">Telefon</label>
                                <input type="text"  name="telefon" class="form-control" id="telefon" placeholder="telefon" value="{{ old('telefon',$entry->telefon) }}">
                            </div>
                            
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="ceptelefonu">Cep Telefon</label>
                                <input type="text"  name="ceptelefonu" class="form-control" id="ceptelefonu" placeholder="ceptelefonu" value="{{ old('ceptelefonu',$entry->ceptelefonu) }}">
                            </div>
                            
                        </div>
                    
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                                <label for="adres">Adres</label>
                                <input type="text"  name="adres" class="form-control" id="adres" placeholder="adres" value="{{ old('adres',$entry->adres) }}">
                            </div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="durum">Sipariş Durumu</label>
                                <select name="durum" id="durum" class="form-control">
                                    <option>seçiniz..</option>
                                <option {{ old('durum',$entry->durum) == 'Siparişiniz Alındı' ? 'selected' : ''}}>Siparişiniz Alındı
                                    
                                </option>
                                  <option  {{ old('durum',$entry->durum) == 'Ödeme Onaylandı' ? 'selected' : ''}}>Ödeme Onaylandı
                                   
                                </option>
                                  <option  {{ old('durum',$entry->durum) == 'Kargoya Verildi' ? 'selected' : ''}}>Kargoya Verildi
                                   
                                </option>
                                  <option  {{ old('durum',$entry->durum) == 'Siparişiniz Tamamlandı' ? 'selected' : ''}}>Siparişiniz Tamamlandı
                                   
                                </option>
                                
                                </select>
                                
                            </div>
                        </div>
                    </div>   
                </form>

                  <h2>Sipariş (SP- {{ $entry->id }})</h2>
                 <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Tutar</th>
                    <th>Adet</th>
                    <th>Ara Toplam</th>
                    <th>Durum</th>
                </tr>
                
                @foreach($entry->sepet->sepet_urunler as $sepet_urun)

                <tr>
                    <td style="width: 120px;"> 
                        <a href="{{ route('urun', $sepet_urun->urun->slug) }}">
                            <img src="{{ ('/uploads/urunler/' . $sepet_urun->urun->detay->urun_resmi) }}">
                        </a>
                    </td>

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
                    <th colspan="2"> {{ $entry->siparis_tutari }} </th>
                    <th></th>
                </tr>

                 <tr>
                   
                    <th colspan="4" class="text-right">Toplam Tutar (KDV dahil) </th>
                    <th colspan="2"> {{ $entry->siparis_tutari * ((100+config('cart.tax'))/100) }} </th>
                    <th></th>
                </tr>


                 <tr>
                   
                    <th colspan="4" class="text-right">Sipariş Durumu </th>
                    <th colspan="2"> {{ $entry->durum}} </th>
                    <th></th>
                </tr>
                

            </table>

 @endsection



