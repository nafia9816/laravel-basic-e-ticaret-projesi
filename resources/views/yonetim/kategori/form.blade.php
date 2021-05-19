@extends('yonetim.layouts.master')
@section('title', 'KATEGORİ Yönetimi')

@section('content')
  <br>
   <h1 class="page-header">Kategori Yönetimi</h1>
                <form method="post" action="{{ route('yonetim.kategori.kaydet', @$entry->id) }}">
            {{ csrf_field() }}

                    <div class="pull-right">
                    	<button type="submit" class="btn btn-warning">
                    		{{ @$entry->id > 0 ? "Güncelle" : "Kaydet" }}
                    	</button>
                    </div>
                    <h2 class="sub-header">
                    	Kategori {{ @$entry->id > 0 ? "Düzenle" : "Ekle" }}
                    </h2>
                    @include('layouts.partials.errors')
                    @include('layouts.partials.alert')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_adi"> Üst Kategori </label>

                                <select name="ust_id" id="ust_id" class="form-control">
                                    <option value=""> Ana Kategori</option>
                                    @foreach($kategoriler as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->kategori_adi }}</option>
                                    @endforeach

                                </select>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_adi">Kategori Adı</label>
                                <input type="text" class="form-control" id="kategori_adi" placeholder="Kategori Adı" name="kategori_adi" value="{{ old('kategori_adi',$entry->kategori_adi) }}">
                                <!-- formda hata olduğunda eski bilgiyi l eski bilgi >yoksa db deki bilgiyi al -->
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="hidden" name="original_slug" value="{{ old('slug',$entry->slug) }}">
                                <input type="text"  name="slug" class="form-control" id="slug" placeholder="Slug" value="{{ old('slug',$entry->slug) }}">
                            </div>
                            
                        </div>
                    </div>
                        
                   
                    

                 
                </form>

 @endsection