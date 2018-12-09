<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>{{$websiteName}} - {{$websiteSubtitle}}</title>
    <!-- Favicon -->
{{--<link href="./assets/img/brand/favicon.png" rel="icon" type="image/png">--}}
<!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{asset('assets/themes/argon/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{asset('assets/themes/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{asset('assets/themes/argon/css/argon-home.css?v=1.0.0')}}" rel="stylesheet">

    <script src="{{asset('assets/themes/argon/js/sweetalert2.all.min.js')}}"></script>
</head>

<body>
<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{url('/')}}">
            @if(empty($websiteLogoUrl))
                <h1 class="mb-1 mt-1" style="color:#5e72e4">{{$websiteLogo}}</h1>
            @else
                <img src="{{$websiteLogoUrl}}" class="navbar-brand-img" alt="">
            @endif
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            {{--<li class="nav-item dropdown">--}}
            {{--<a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
            {{--<i class="ni ni-bell-55"></i>--}}
            {{--</a>--}}
            {{--<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">--}}
            {{--<a class="dropdown-item" href="#">Action</a>--}}
            {{--<a class="dropdown-item" href="#">Another action</a>--}}
            {{--<div class="dropdown-divider"></div>--}}
            {{--<a class="dropdown-item" href="#">Something else here</a>--}}
            {{--</div>--}}
            {{--</li>--}}
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="{{Auth::user()->avatar}}">
              </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <a href="{{route('home')}}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>用户中心</span>
                    </a>
                    <a href="{{route('user.profile')}}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>个人设置</span>
                    </a>
                    <a href="{{route('new.show')}}" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>公告新闻</span>
                    </a>
                    <a href="{{route('host.show')}}" class="dropdown-item">
                        <i class="ni ni-bullet-list-67"></i>
                        <span>产品管理</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>登出</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{url('/')}}">
                            @if(empty($websiteLogoUrl))
                                <h1 class="mb-1 mt-1" style="color:#5e72e4">{{$websiteLogo}}</h1>
                            @else
                                <img src="{{$websiteLogoUrl}}" class="navbar-brand-img" alt="">
                            @endif
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
        {{--<form class="mt-4 mb-3 d-md-none">--}}
        {{--<div class="input-group input-group-rounded input-group-merge">--}}
        {{--<input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">--}}
        {{--<div class="input-group-prepend">--}}
        {{--<div class="input-group-text">--}}
        {{--<span class="fa fa-search"></span>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</form>--}}
        <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.home')}}">
                        <i class="ni ni-tv-2 text-primary"></i> 数据面板
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.good.show')}}">
                        <i class="ni ni-planet text-blue"></i> 商品管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.work.order.show')}}">
                        <i class="ni ni-pin-3 text-orange"></i> 工单管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.user.show')}}">
                        <i class="ni ni-single-02 text-yellow"></i> 用户管理
                    </a>
                </li>
                {{--<li class="nav-item">--}}
                {{--<a class="nav-link" href="{{route('host.show')}}">--}}
                {{--<i class="ni ni-bullet-list-67 text-red"></i> 订单管理--}}
                {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.order.show')}}">
                        <i class="ni ni-single-copy-04 text-purple"></i> 订单管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.host.show')}}">
                        <i class="ni ni-calendar-grid-58 text-info"></i> 主机管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.new.show')}}">
                        <i class="ni ni-bell-55 text-pink"></i> 公告管理
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.setting.index')}}">
                        <i class="ni ni-settings-gear-65 text-red"></i>系统设置
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.server.show')}}">
                        <i class="ni ni-building text-purple"></i> 服务器管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.prepaid.key.show')}}">
                        <i class="ni ni-credit-card text-blue"></i> 卡密管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.server.show')}}">
                        <i class="ni ni-money-coins text-indigo"></i> 推广管理
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">
                        <i class="ni ni-ungroup text-cyan"></i> 用户中心
                    </a>
                </li>
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">帮助</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="ni ni-spaceship"></i> 联系客服
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="main-content">

@auth()
    <!-- Top navbar -->
        <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"
                   href="{{url('/')}}">{{$websiteName}}</a>
                <!-- Form -->
            {{--<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">--}}
            {{--<div class="form-group mb-0">--}}
            {{--<div class="input-group input-group-alternative">--}}
            {{--<div class="input-group-prepend">--}}
            {{--<span class="input-group-text"><i class="fas fa-search"></i></span>--}}
            {{--</div>--}}
            {{--<input class="form-control" placeholder="Search" type="text">--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</form>--}}
            <!-- User -->
                <ul class="navbar-nav align-items-center d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="{{Auth::user()->avatar}}">
                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome!</h6>
                            </div>
                            <a href="{{route('home')}}" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>用户中心</span>
                            </a>
                            <a href="{{route('user.profile')}}" class="dropdown-item">
                                <i class="ni ni-settings-gear-65"></i>
                                <span>个人设置</span>
                            </a>
                            <a href="{{route('new.show')}}" class="dropdown-item">
                                <i class="ni ni-calendar-grid-58"></i>
                                <span>公告新闻</span>
                            </a>
                            <a href="{{route('host.show')}}" class="dropdown-item">
                                <i class="ni ni-bullet-list-67"></i>
                                <span>产品管理</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="ni ni-user-run"></i>
                                <span>登出</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    @endauth

    @yield('content')
    <div class="container-fluid mt--7">
        @yield('container-fluid')
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        &copy; 2018 <a href="http://TomatoIDC.com" class="font-weight-bold ml-1"
                                       target="_blank">TomatoIDC</a>
                    </div>
                </div>
                <div class="col-xl-6">
                    <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                        <li class="nav-item">
                            <a href="http://mercycloud.com" class="nav-link" target="_blank">MercyCloud</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.gnu.org/licenses/gpl-3.0.en.html"
                               class="nav-link" target="_blank">GPL3.0</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>

@if(session('status'))
    @if(session('status') == 'success')
        <script>
            swal(
                'Success!',
                '操作成功',
                'success'
            )
        </script>
    @else
        <script>
            swal({
                type: 'error',
                title: 'Error',
                text: '操作失败',
            })
        </script>
    @endif
@endif
<script src="{{asset('assets/themes/argon/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/themes/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- Optional JS -->
<script src="{{asset('assets/themes/argon/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('assets/themes/argon/vendor/chart.js/dist/Chart.extension.js')}}"></script>
<!-- Argon JS -->
<script src="{{asset('assets/themes/argon/js/argon-home.js?v=1.0.0')}}"></script>
</body>
</html>
