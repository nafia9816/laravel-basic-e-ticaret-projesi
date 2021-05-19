@extends('yonetim.layouts.master')

@section('title','Kontrol Paneli')

@section('content')
    <br>
   <h1 class="page-header">Dashboard</h1>

                <section class="row text-center placeholders">
                    <div class="col-6 col-sm-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Bekleyen Sipariş</div>
                            <div class="panel-body">
                                <h4>{{ $istatistikler['bekleyen_siparis'] }}</h4>
                                <p>Adet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Tamamlanan Sipariş</div>
                            <div class="panel-body">
                                <h4>{{ $istatistikler['tamamlanan_siparis'] }}</h4>
                                <p>Adet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Ürün</div>
                            <div class="panel-body">
                                <h4>{{ $istatistikler['toplam_urun'] }}</h4>
                                <p>Adet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Kullanıcı</div>
                            <div class="panel-body">
                                <h4>{{ $istatistikler['toplam_kullanici'] }}</h4>
                                <p>Adet</p>
                            </div>
                        </div>
                    </div>
                </section>

              









@endsection
