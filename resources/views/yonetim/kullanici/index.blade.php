@extends('yonetim.layouts.master')
@section('title', 'Kullanıcı Yönetimi')

@section('content')
  <br>
 <h1 class="page-header">Kullanıcı Yönetimi </h1>
 <h1 class="sub-header">
 	                <h3>Kullanıcı Listesi </h3>
 	                <div class="well">
                    <div class="btn-group pull-right" role="group" aria-label="Basic example">
                        <a href="{{ route('yonetim.kullanici.yeni') }}" class="btn btn-primary">Yeni</a>
                    </div>
                    <form method="post" action="{{ route('yonetim.kullanici') }}" class="form-inline">
                    	{{csrf_field()}}
                    	<div class="form-group">
                    		<label for="aranan">Ara</label>
                    		<input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ad, Email ara..." value="{{ old('aranan') }}">
                    	</div>
                    	<button type="submit" class="btn btn-danger">Ara</button>
                    	<a href="{{ route('yonetim.kullanici') }}" class="btn btn-warning">Temizle</a>

                    </form>
                  </div>
                @include('layouts.partials.alert')
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Adı Soyadı</th>
                                <th>Email</th>
                                <th>Aktif mi</th>
                                <th>Yönetici mi</th>
                                <th>Kayıt Tarihi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($list) == 0)
                              <tr>
                                  <td colspan="6" class="text-center">Kayıt Bulunamadı</td>
                              </tr>
                            @endif
                            @foreach($list as $entry)
                            <tr>
                                <td>{{ $entry->id }}</td>
                                <td>{{ $entry->adsoyad }}</td>
                                <td>{{ $entry->email }}</td>

                                <td> @if($entry->aktif_mi)
                                	<span class="label label-success">Aktif</span>
                                	@else
                                	 <span class="label label-warning">Pasif</span>
                                	@endif
                                </td>

                                <td> @if($entry->yonetici_mi)
                                	<span class="label label-success">Yönetici</span>
                                	@else
                                	 <span class="label label-warning">Müşteri</span>
                                	@endif
                                </td>
                                
                                <td>{{ $entry->olusma_tarihi }}</td>

                                <td style="width: 100px">
                                    <a href="{{ route('yonetim.kullanici.duzenle', $entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                    <a href="{{ route('yonetim.kullanici.sil',$entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misin?')">
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