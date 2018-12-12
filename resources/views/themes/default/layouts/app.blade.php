<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{$websiteSubtitle}}">
    <meta name="author" content="Creative Tim & yranarf">
    <title>{{$websiteName}} - {{$websiteSubtitle}}</title>
    <!-- Favicon -->
{{--<link href="{{asset('assets/themes/argon/img/brand/favicon.png" rel="icon" type="image/png">--}}
<!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{asset('assets/themes/argon/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{asset('assets/themes/argon/vendor/font-awesome/css/font-awesome.min.css')}}" rel="s')}}tylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{asset('assets/themes/argon/css/argon.css?v=1.0.1')}}" rel="stylesheet">
    <script src="{{asset('assets/themes/argon/js/sweetalert2.all.min.js')}}"></script>
</head>

<body>
<header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
        <div class="container">
            <a class="navbar-brand mr-lg-5" href="/">
                <h4 style="color: white">{{$websiteName}}</h4>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
                    aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="/">
                                <h4 style="color: white">{{$websiteName}}</h4>
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                    data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                    <li class="nav-item dropdown">
                        <a href="/" class="nav-link" data-toggle="dropdown-item" role="button">
                            <i class="ni ni-ui-04 d-lg-none"></i>
                            <span class="nav-link-inner--text">首页</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="{{route('good.show')}}" class="nav-link" data-toggle="dropdown-item" role="button">
                            <i class="ni ni-ui-04 d-lg-none"></i>
                            <span class="nav-link-inner--text">订购产品</span>
                        </a>
                    </li>

                    @guest
                        <li class="nav-item dropdown">
                            <a href="{{route('login')}}" class="nav-link" data-toggle="dropdown-item" role="button">
                                <i class="ni ni-ui-04 d-lg-none"></i>
                                <span class="nav-link-inner--text">登入</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="{{route('register')}}" class="nav-link" data-toggle="dropdown-item" role="button">
                                <i class="ni ni-ui-04 d-lg-none"></i>
                                <span class="nav-link-inner--text">注册</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a href="{{route('home')}}" class="nav-link" data-toggle="dropdown-item" role="button">
                                <i class="ni ni-ui-04 d-lg-none"></i>
                                <span class="nav-link-inner--text">用户中心</span>
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
@yield('content')


<footer class="footer has-cards">
    <div class="container">
        <div class="row row-grid align-items-center my-md">
            <div class="col-lg-6">
                <h3 class="text-primary font-weight-light mb-2">心动不如行动!</h3>
                <h4 class="mb-0 font-weight-light">一个虚拟主机,圆你一个网站梦立即订购吧~.</h4>
            </div>
        </div>
        <hr>
        <div class="row align-items-center justify-content-md-between">
            <div class="col-md-6">
                <div class="copyright">
                    {{$copyright}}
                    <a href="/" target="_blank"> {{$websiteName}}</a>.
                </div>
            </div>
            <div class="col-md-6">
                <ul class="nav nav-footer justify-content-end">
                    <li class="nav-item">
                        <a href="{{$websiteKfUrl}}" class="nav-link" target="_blank">客服帮助</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{$privacyPolicy}}" class="nav-link" target="_blank">服务协议</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{$userAgreements}}" class="nav-link" target="_blank">隐私协议</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- Core -->
<script src="{{asset('assets/themes/argon/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/themes/argon/vendor/popper/popper.min.js')}}"></script>
<script src="{{asset('assets/themes/argon/vendor/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/themes/argon/vendor/headroom/headroom.min.js')}}"></script>
<!-- Argon JS -->
<script src="{{asset('assets/themes/argon/js/argon.js?v=1.0.1')}}"></script>
</body>

</html>
