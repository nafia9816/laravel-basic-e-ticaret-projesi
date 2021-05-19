@extends('layouts.master')

@section('content')
   
   <div class="jumbotron text-center">
   	   <h1>404</h1>
   	   <h2>Aradığınız sayfaya bulunamadı</h2>
   	   <a href="{{ route('anasayfa') }}" class="btn btn-primary">Anasayfa'ya Dön</a>
   </div>

@endsection