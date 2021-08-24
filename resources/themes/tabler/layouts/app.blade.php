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
    <title></title>
    <!-- CSS files -->
    <link href="{{asset("{$themeAssets}/css/tabler.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-flags.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-payments.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/tabler-vendors.min.css")}}" rel="stylesheet"/>
    <link href="{{asset("{$themeAssets}/css/demo.min.css")}}" rel="stylesheet"/>

    <script src="{{asset("{$themeAssets}/plugin/dropzone-5.7.0/dist/dropzone.css")}}"></script>
    <script src="{{asset("{$themeAssets}/plugin/datetimepicker/jquery.datetimepicker.min.css")}}"></script>
    @yield('css')
</head>
<body class="antialiased">
<div class="wrapper">
    <header class="navbar navbar-expand-md navbar-dark d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href=".">
                    <h2>HStack</h2>
                    {{--                    <img src="./static/logo-white.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">--}}
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-none d-md-flex me-3">

                </div>
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                        <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    @auth()
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{Auth::user()->profile_photo_url }})"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{Auth::user()->name}}</div>
                            <div class="mt-1 small text-muted">{{Auth::user()->email}}</div>
                        </div>
                    </a>
                    @endauth
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="#" class="dropdown-item">Set status</a>
                        <a href="#" class="dropdown-item">Profile & account</a>
                        <a href="#" class="dropdown-item">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('dashboard')}}" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                                <span class="nav-link-title">
                      Home
                    </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" /><line x1="12" y1="12" x2="20" y2="7.5" /><line x1="12" y1="12" x2="12" y2="21" /><line x1="12" y1="12" x2="4" y2="7.5" /><line x1="16" y1="5.25" x2="8" y2="9.75" /></svg>
                    </span>
                                <span class="nav-link-title">
                      Interface
                    </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="./empty.html" >
                                            Empty page
                                        </a>
                                        <a class="dropdown-item" href="./accordion.html" >
                                            Accordion
                                        </a>
                                        <a class="dropdown-item" href="./blank.html" >
                                            Blank page
                                        </a>
                                        <a class="dropdown-item" href="./buttons.html" >
                                            Buttons
                                        </a>
                                        <a class="dropdown-item" href="./cards.html" >
                                            Cards
                                        </a>
                                        <a class="dropdown-item" href="./cards-masonry.html" >
                                            Cards Masonry
                                        </a>
                                        <a class="dropdown-item" href="./colors.html" >
                                            Colors
                                        </a>
                                        <a class="dropdown-item" href="./dropdowns.html" >
                                            Dropdowns
                                        </a>
                                        <a class="dropdown-item" href="./icons.html" >
                                            Icons
                                        </a>
                                        <a class="dropdown-item" href="./modals.html" >
                                            Modals
                                        </a>
                                        <a class="dropdown-item" href="./maps.html" >
                                            Maps
                                        </a>
                                        <a class="dropdown-item" href="./map-fullsize.html" >
                                            Map fullsize
                                        </a>
                                        <a class="dropdown-item" href="./maps-vector.html" >
                                            Vector maps
                                        </a>
                                    </div>
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="./navigation.html" >
                                            Navigation
                                        </a>
                                        <a class="dropdown-item" href="./charts.html" >
                                            Charts
                                        </a>
                                        <a class="dropdown-item" href="./pagination.html" >
                                            Pagination
                                        </a>
                                        <a class="dropdown-item" href="./skeleton.html" >
                                            Skeleton
                                        </a>
                                        <a class="dropdown-item" href="./tabs.html" >
                                            Tabs
                                        </a>
                                        <a class="dropdown-item" href="./tables.html" >
                                            Tables
                                        </a>
                                        <a class="dropdown-item" href="./carousel.html" >
                                            Carousel
                                        </a>
                                        <a class="dropdown-item" href="./lists.html" >
                                            Lists
                                        </a>
                                        <a class="dropdown-item" href="./typography.html" >
                                            Typography
                                        </a>
                                        <a class="dropdown-item" href="./markdown.html" >
                                            Markdown
                                        </a>
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                                                Authentication
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="./sign-in.html" class="dropdown-item">Sign in</a>
                                                <a href="./sign-up.html" class="dropdown-item">Sign up</a>
                                                <a href="./forgot-password.html" class="dropdown-item">Forgot password</a>
                                                <a href="./terms-of-service.html" class="dropdown-item">Terms of service</a>
                                                <a href="./auth-lock.html" class="dropdown-item">Lock screen</a>
                                            </div>
                                        </div>
                                        <div class="dropend">
                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-error" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                                                Error pages
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="./error-404.html" class="dropdown-item">404 page</a>
                                                <a href="./error-500.html" class="dropdown-item">500 page</a>
                                                <a href="./error-maintenance.html" class="dropdown-item">Maintenance page</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    {{--                    搜索--}}
                    {{--                    <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">--}}
                    {{--                        <form action="." method="get">--}}
                    {{--                            <div class="input-icon">--}}
                    {{--                    <span class="input-icon-addon">--}}
                    {{--                      <!-- Download SVG icon from http://tabler-icons.io/i/search -->--}}
                    {{--                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>--}}
                    {{--                    </span>--}}
                    {{--                                <input type="text" class="form-control" placeholder="Search…" aria-label="Search in website">--}}
                    {{--                            </div>--}}
                    {{--                        </form>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="container-xl">
        </div>
        <div class="page-body">
            @yield('content')
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-lg-auto ms-lg-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item"><a href="./docs/index.html" class="link-secondary">Documentation</a></li>
                            <li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a></li>
                            <li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank" class="link-secondary" rel="noopener">Source code</a></li>
                            <li class="list-inline-item">
                                <a href="https://github.com/sponsors/codecalm" target="_blank" class="link-secondary" rel="noopener">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink icon-filled icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                                    Sponsor
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Theme by <a href="https://github.com/tabler/tabler">tabler</a> <br>
                                Copyright &copy; 2021
                                <a href="." class="link-secondary">MercyCloud</a>.
                                All rights reserved.
                            </li>
                            <li class="list-inline-item">
                                <a href="" class="link-secondary" rel="noopener">v1.0.0</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@yield('addons')
<!-- Libs JS -->
<script src="{{asset("{$themeAssets}/plugin/dropzone-5.7.0/dist/dropzone.js.map")}}"></script>
<script src="{{asset("{$themeAssets}/plugin/datetimepicker/jquery.datetimepicker.full.js")}}"></script>
<!-- Tabler Core -->

<script src="{{asset("{$themeAssets}/js/tabler.min.js")}}"></script>
@yield('script')
</body>
</html>
