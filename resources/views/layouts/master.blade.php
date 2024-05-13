<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Food Store</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
        @include('layouts.header')
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-2 col-md-3 sidebar-div">
            @include('layouts.sidebar')
        </div>
        <div class="col-lg-9 col-md-9 ps-lg-5 ps-md-5 ps-sm-3">
            @yield('content')
        </div>
    </div>
</div>
<footer>
</footer>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
