<!doctype html>
<!--
* HStack
* Theme Design By Tabler(tabler.io)
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatiible" content="ie=edge"/>
    <title></title>
    <!-- CSS files -->
    <link href="{{asset("{$themeAssets}/css/tabler.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-flags.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-payments.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-vendors.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/iconfont/tabler-icons.min.css")}}" rel="stylesheet"/>
{{--    <link href="{{asset("{$themeAssets}/css/demo.min.css")}}" rel="stylesheet"/>--}}

    @yield('css')
</head>
<body class="antialiased">
<div class="wrapper">
    @include('theme::layouts.header')
    <div class="page-wrapper">
        <div class="container-xl">
            @yield('header')
        </div>
        <div class="page-body">
            @yield('content')
        </div>
        @include('theme::layouts.footer')
    </div>
</div>
@yield('addons')
<!-- Tabler Core -->

<script src="{{asset("{$themeAssets}/js/tabler.min.js")}}"></script>
@yield('script')
</body>
</html>
