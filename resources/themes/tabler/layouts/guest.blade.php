<!doctype html>
<!--
* HStack
* Theme Design By Tabler(tabler.io)
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign up - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{asset("{$themeAssets}/css/tabler.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-flags.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-payments.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-vendors.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/demo.min.css")}}" rel="stylesheet"/>
</head>
<body class="antialiased border-top-wide border-primary d-flex flex-column">
<div class="page page-center">
    @yield('content')
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="{{asset("{$themeAssets}/js/tabler.min.js")}}"></script>
@yield('script')
</body>
</html>
