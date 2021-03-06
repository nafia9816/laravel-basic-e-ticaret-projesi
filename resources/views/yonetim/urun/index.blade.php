@extends('yonetim.layouts.master')
@section('title', 'Ürün Yönetimi')

@section('content')
  <br>
 <h1 class="page-header">Ürün Yönetimi </h1>
 <h1 class="sub-header">
 	                <h3>Ürün Listesi </h3>
 	                <div class="well">
                    <div class="btn-group pull-right" role="group" aria-label="Basic example">
                        <a href="{{ route('yonetim.urun.yeni') }}" class="btn btn-primary">Yeni</a>
                    </div>
                    <form method="post" action="{{ route('yonetim.urun') }}" class="form-inline">
                    	{{csrf_field()}}
                    	<div class="form-group">
                    		<label for="aranan">Ara</label>
                    		<input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ürün ara..." value="{{ old('aranan') }}">
                    	</div>
                    	<button type="submit" class="btn btn-danger">Ara</button>
                    	<a href="{{ route('yonetim.urun') }}" class="btn btn-warning">Temizle</a>

                    </form>
                  </div>
                @include('layouts.partials.alert')
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Slug</th>
                                <th>Ürün Adı</th>
                                <th>Fiyatı</th>
                                <th>Kayıt Tarihi</th>
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
                                <td>{{ $entry->id }}</td>
                                <td>{{ $entry->slug }}</td>
                                <td>{{ $entry->urun_adi }}</td>
                                <td>{{ $entry->fiyati }}</td>
                                <td>{{ $entry->olusma_tarihi }}</td>

                                <td style="width: 100px">
                                    <a href="{{ route('yonetim.urun.duzenle', $entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                    <a href="{{ route('yonetim.urun.sil',$entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misin?')">
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