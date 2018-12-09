<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>TomatoIDC Install|虚拟主机销售系统|MercyCloud|TomatoProject</title>
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
</head>

</head>

<body class="bg-default">
<div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
        <div class="container px-4">
            <a class="navbar-brand pt-0" href="{{url('/install')}}">
                <h1 class="mb-1 mt-1" style="color:#FFF">TomatoIDC</h1>
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
                            <a href="../index.html">
                                <img src="../assets/img/brand/blue.png">
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
                        <a class="nav-link nav-link-icon" href="https://mercycloud.com">
                            <i class="ni ni-planet"></i>
                            <span class="nav-link-inner--text">MercyCloud</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="https://github.com/MercyCloudTeam/TomatoIDC">
                            <i class="ni ni-circle-08"></i>
                            <span class="nav-link-inner--text">Github</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">TomatoIDC</h1>
                        <p class="text-lead text-light">
                            TomatoIDC是一款以GPL3.0协议开源虚拟主机销售系统，具备易于扩展的插件系统，模版系统，使用强大的Laravel框架进行驱动，能帮助你轻松的扩展虚拟主机销售业务。</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>请填写安装信息</small>
                        </div>
                        <form class="form" href="{{url('/install')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-air-baloon"></i></span>
                                    </div>
                                    <input type="text" name="title" value="{{old('title')}}" required
                                           class="form-control" placeholder="网站名称">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input type="email" name="email" required placeholder="管理员邮箱"
                                           value="{{old('email')}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                    </div>
                                    <input type="text" required name="name" class="form-control"
                                           value="{{{old('name')}}}" placeholder="管理员用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input type="password" required name="password" class="form-control"
                                           placeholder="管理员密码">
                                </div>
                            </div>
                            {{--<div class="custom-control custom-control-alternative custom-checkbox">--}}
                            {{--<input class="custom-control-input" id=" customCheckLogin" type="checkbox">--}}
                            {{--<label class="custom-control-label" for=" customCheckLogin">--}}
                            {{--<span class="text-muted">Remember me</span>--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" style="margin-top: 2rem" role="alert">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary my-4" value="安装">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<footer class="py-5">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-6">
                <div class="copyright text-center text-xl-left text-muted">
                    TomatoIDC &copy; 2018 <a href="https://mercycloud.com" class="font-weight-bold ml-1"
                                             target="_blank">MercyCloud</a>
                    Design : <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative
                        Tim</a>
                </div>
            </div>
            <div class="col-xl-6">
                <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                    <li class="nav-item">
                        <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://github.com/MercyCloudTeam/TomatoIDC" class="nav-link"
                           target="_blank">TomatoIDC</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://mercycloud.com" class="nav-link" target="_blank">MercyCloud</a>
                    </li>
                </ul>
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
