<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title',config('app.name'))</title>

    @include('layouts.partials.head')

    @yield('head') <!-- bu kısmı alt sayfalarda head kısmına eksta bişety eklemek istersem diye değişken alan olrak belirledim-->
    





   
</head>

<body id="commerce">
    @include('layouts.partials.navbar')

    @yield('content')

    @include('layouts.partials.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @yield('footer')<!-- bu kısmı alt sayfalarda head kısmına eksta bişety eklemek istersem diye değişken alan olrak belirledim-->
</body>

</html>