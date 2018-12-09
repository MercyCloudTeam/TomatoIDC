<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$websiteName}} - {{$websiteSubtitle}}</title>
    <!-- Favicon -->
    {{--<link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">--}}
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{asset('assets/themes/argon/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{asset('assets/themes/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{asset('assets/themes/argon/css/argon-home.css?v=1.0.0')}}" rel="stylesheet">

    <script src="{{asset('assets/themes/argon/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/themes/argon/js/sweetalert2.all.min.js')}}"></script>
</head>

</head>

<body class="bg-default">
<div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
        <div class="container px-4">
            <a class="navbar-brand pt-0" href="{{url('/home')}}">
                @if(empty($websiteLogoUrl))
                    <h1 class="mb-1 mt-1" style="color:#FFF">{{$websiteLogo}}</h1>
                @else
                    <img src="{{$websiteLogoUrl}}" class="navbar-brand-img" alt="">
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{url('/home')}}">
                                @if(empty($websiteLogoUrl))
                                    <h1 class="mb-1 mt-1" style="color:#FFF">{{$websiteLogo}}</h1>
                                @else
                                    <img src="{{$websiteLogoUrl}}" class="navbar-brand-img" alt="">
                                @endif
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                    data-target="#navbar-collapse-main" aria-controls="sidenav-main"
                                    aria-expanded="false" aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Navbar items -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{$websiteKfUrl}}">
                            <i class="ni ni-planet"></i>
                            <span class="nav-link-inner--text">联系客服</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{url('/home')}}">
                            <i class="ni ni-circle-08"></i>
                            <span class="nav-link-inner--text">用户中心</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</div>
<!-- Footer -->
<footer class="py-5">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-6">
                <div class="copyright text-center text-xl-left text-muted">
                    {{$websiteName}} &copy; 2018 <a href="{{url('/')}}" class="font-weight-bold ml-1" target="_blank">{{$copyright}}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Argon Scripts -->
<!-- Core -->
<script src="{{asset('assets/themes/argon/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/themes/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- Argon JS -->
<script src="{{asset('assets/themes/argon/js/argon-home.js?v=1.0.0')}}"></script>
</body>

</html>
