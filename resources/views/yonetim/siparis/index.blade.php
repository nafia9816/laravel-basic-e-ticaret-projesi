@extends('yonetim.layouts.master')
@section('title', 'Sipariş Yönetimi')

@section('content')
  <br>
 <h1 class="page-header">Sipariş  Yönetimi </h1>
 <h1 class="sub-header">
 	                <h3>Sipariş  Listesi </h3>
 	                <div class="well">
                    <div class="btn-group pull-right" role="group" aria-label="Basic example">
                        <a href="{{ route('yonetim.siparis.yeni') }}" class="btn btn-primary">Yeni</a>
                    </div>
                    <form method="post" action="{{ route('yonetim.siparis') }}" class="form-inline">
                    	{{csrf_field()}}
                    	<div class="form-group">
                    		<label for="aranan">Ara</label>
                    		<input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Sipariş ara..." value="{{ old('aranan') }}">
                    	</div>
                    	<button type="submit" class="btn btn-danger">Ara</button>
                    	<a href="{{ route('yonetim.siparis') }}" class="btn btn-warning">Temizle</a>

                    </form>
                  </div>
                @include('layouts.partials.alert')
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sipariş Kodu</th>
                                <th>Kullanıcı</th>
                                
                                <th>Tutar</th>
                                <th>Durum</th>
                                <th>Sipariş Tarihi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($list) == 0)
                              <tr>
                                  <td colspan="5" class="text-center">Kayıt Bulunamadı</td>
                              </tr>
                            @endif
                            @foreach($list as $entry)
                            <tr>
                                <td>SP- {{ $entry->id }}</td>
                                <td>{{ $entry->sepet->kullanici->adsoyad}}</td>
                                
                                <td>{{ $entry->siparis_tutari * (100 + config('cart.tax'))/100}}</td>
                                <td>{{ $entry->durum }}</td>
                                <td>{{ $entry->olusma_tarihi }}</td>

                                <td style="width: 100px">
                                    <a href="{{ route('yonetim.siparis.duzenle', $entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                    <a href="{{ route('yonetim.siparis.sil',$entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misin?')">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $list->appends('aranan',old('aranan'))-> links() }}
                </div>















@endsection