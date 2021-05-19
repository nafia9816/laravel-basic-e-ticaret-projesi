@extends('yonetim.layouts.master')
@section('title', 'Ürün Yönetimi')

@section('content')
  <br>
   <h1 class="page-header">Ürün Yönetimi</h1>
                <form method="post" action="{{ route('yonetim.urun.kaydet', @$entry->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}

                    <div class="pull-right">
                    	<button type="submit" class="btn btn-warning">
                    		{{ @$entry->id > 0 ? "Güncelle" : "Kaydet" }}
                    	</button>
                    </div>
                    <h2 class="sub-header">
                    	Ürün {{ @$entry->id > 0 ? "Düzenle" : "Ekle" }}
                    </h2>
                    @include('layouts.partials.errors')
                    @include('layouts.partials.alert')
               
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="urun_adi">Ürün Adı</label>
                                <input type="text" class="form-control" id="urun_adi" placeholder="Ürün Adı" name="urun_adi" value="{{ old('urun_adi',$entry->urun_adi) }}">
                                <!-- formda hata olduğunda eski bilgiyi l eski bilgi >yoksa db deki bilgiyi al -->
                            </div>
                        </div>

                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="hidden" name="original_slug" value="{{ old('slug',$entry->slug) }}">
                                <input type="text"  name="slug" class="form-control" id="slug" placeholder="Slug" value="{{ old('slug',$entry->slug) }}">
                            </div>
                            
                        </div>
                    
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="aciklama">Açıklama</label>
                                <textarea class="form-control" id="aciklama" name="aciklama" placeholder="Açıklama">
                                    {{ old('urun_adi',$entry->aciklama) }}
                                </textarea>
                                <!-- formda hata olduğunda eski bilgiyi l eski bilgi >yoksa db deki bilgiyi al -->
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fiyati">Fiyatı</label>
                                <input type="text" class="form-control" id="fiyati" placeholder="Ürün Adı" name="fiyati" value="{{ old('fiyati',$entry->fiyati) }}">
                                <!-- formda hata olduğunda eski bilgiyi l eski bilgi >yoksa db deki bilgiyi al -->
                            </div>
                        </div>
                    </div>

                    <!-- ÜRÜN DETAYLARININ ALANLARINI EKLIYORUZ-->
                    <div class="checkbox">
                        <label>
                            <input type="hidden" name="goster_slider" value="0" >
                            <input type="checkbox" name="goster_slider" value="1" {{ old('goster_slider',$entry->detay->goster_slider) ? 'checked' : '' }}> Slider da Göster
                        </label>

                         <label>
                            <input type="hidden" name="goster_gunun_firsati" value="0" >
                            <input type="checkbox" name="goster_gunun_firsati" value="1" {{ old('goster_gunun_firsati',$entry->detay->goster_gunun_firsati) ? 'checked' : '' }}>Günün Fırsatında Göster
                        </label>

                        <label>
                            <input type="hidden" name="goster_one_cikanlar" value="0" >
                            <input type="checkbox" name="goster_one_cikanlar" value="1" {{ old('goster_one_cikanlar',$entry->detay->goster_one_cikanlar) ? 'checked' : '' }}>Öne Çıkanlarda Göster
                        </label>

                        <label>
                            <input type="hidden" name="goster_cok_satanlar" value="0" >
                            <input type="checkbox" name="goster_cok_satanlar" value="1" {{ old('goster_cok_satanlar',$entry->detay->goster_cok_satanlar) ? 'checked' : '' }}>Çok Satanlarda Göster
                        </label>

                        <label>
                            <input type="hidden" name="goster_indirimli" value="0" >
                            <input type="checkbox" name="goster_indirimli" value="1" {{ old('goster_indirimli',$entry->detay->goster_indirimli) ? 'checked' : '' }}>İndirimli Olanlarda Göster
                        </label>
                    </div>

                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kategoriler">Kategoriler</label>
                                <select name="kategoriler[]" id="kategoriler" multiple class="form-control">
                                    @foreach($kategoriler as $kategori)
                                    <option value="{{ $kategori->id }}" {{ collect(old('kategoriler', $urun_kategorileri))->contains($kategori->id) ? 'selected' : '' }} >
                                    {{ $kategori->kategori_adi }}
                                </option>
                                @endforeach
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        @if($entry->detay->urun_resmi!=null)
                           <img src="/uploads/urunler/" style="height: 100px; margin-right:20px; " class="thumbnail pull-left" {{ $entry->detay->urun_resmi }} >
                        @endif
                        <label for="urun_resmi">Ürün Resmi</label>
                        <input type="file" id="urun_resmi" name="urun_resmi" >
                    </div>
                   
                    

                 
                </form>

 @endsection


@section('head')
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
 @endsection

@section('footer')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>

<script>
    $(function(){
        $('#kategoriler').select2({
            placeholder: 'Lütfen kategorileri seçiniz.'
        });

        CKEDITOR.replace('aciklama');
    });
</script>

@endsection

