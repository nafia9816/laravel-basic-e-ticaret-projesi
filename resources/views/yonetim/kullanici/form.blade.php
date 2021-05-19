@extends('yonetim.layouts.master')
@section('title', 'Kullanıcı Yönetimi')

@section('content')
  <br>
   <h1 class="page-header">Kullanıcı Yönetimi</h1>
                <form method="post" action="{{ route('yonetim.kullanici.kaydet', @$entry->id) }}">
            {{ csrf_field() }}

                    <div class="pull-right">
                    	<button type="submit" class="btn btn-warning">
                    		{{ @$entry->id > 0 ? "Güncelle" : "Kaydet" }}
                    	</button>
                    </div>
                    <h2 class="sub-header">
                    	Kullancı {{ @$entry->id > 0 ? "Düzenle" : "Ekle" }}
                    </h2>
                    @include('layouts.partials.errors')
                    @include('layouts.partials.alert')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="adsoyad">Ad Soyad</label>
                                <input type="text" class="form-control" id="adsoyad" placeholder="Adı Soyadı" name="adsoyad" value="{{ old('adsoyad',$entry->adsoyad) }}">
                                <!-- formda hata olduğunda eski bilgiyi l eski bilgi >yoksa db deki bilgiyi al -->

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email"  name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email',$entry->email) }}">
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sifre">Şifre</label>
                                <input type="password" class="form-control" id="sifre" name="sifre" placeholder="sifre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="adres">Adres</label>
                                <input type="text" class="form-control" id="adres"  name="adres" placeholder="Adresi" value="{{ old('adres',$entry->detay->adres) }}">
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="telefon">Telefon</label>
                                <input type="text" class="form-control" id="telefon" name="teledon" placeholder="Telefonu" value="{{ old('telefon',$entry->detay->telefon) }}">
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ceptelefonu">Cep Telefon</label>
                                <input type="text" class="form-control" id="ceptelefonu" name="ceptelefonu" placeholder="Cep Telefonu" value="{{ old('ceptelefonu',$entry->detay->ceptelefonu) }}">
                            </div>
                        </div>
                    </div>
              
                    <div class="checkbox">
                        <label>
                        	<input type="hidden" name="aktif_mi" value="0">
                            <input type="checkbox" name="aktif_mi" value="1" {{ old('aktif_mi' ,$entry->aktif_mi) ? 'checked' : '' }}>Aktif Mi?
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                        	<input type="hidden" name="yonetici_mi" value="0">
                            <input type="checkbox" name="yonetici_mi" value="1" 
                            {{ old( 'yonetici_mi',$entry->yonetici_mi) ? 'checked' : '' }}> <!-- burası satesinde yöneticiyse check bos tikli gelecek aynı sekilde aktifsede -->
                            Yönetici Mi?
                        </label>
                    </div>
                 
                </form>

 @endsection