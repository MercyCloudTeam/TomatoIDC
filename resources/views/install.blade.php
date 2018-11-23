{{--<来自Blk注册界面--}}
        <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Tomatoidc V0 Install 安装
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/themes/blk/css/nucleo-icons.css/')}}" rel="stylesheet"/>
    <!-- CSS Files -->
    <link href="{{asset('assets/themes/blk/css/blk-design-system.css?v=1.0.0')}}" rel="stylesheet"/>
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{asset('assets/themes/blk//demo/demo.css" rel="stylesheet')}}"/>
</head>

<body class="register-page">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-transparent " color-on-scroll="100">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="https://demos.creative-tim.com/blk-design-system/index.html" rel="tooltip"
               title="Designed and Coded by Creative Tim" data-placement="bottom" target="_blank">
                <span>Yranarf V2 </span> YFsama
            </a>
            <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                    aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a>
                            yranarf
                        </a>
                    </div>
                    <div class="col-6 collapse-close text-right">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navigation"
                                aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="tim-icons icon-simple-remove"></i>
                        </button>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav">
                {{--<li class="nav-item p-0">--}}
                {{--<a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom" href="" target="_blank">--}}
                {{--<i class="fab fa-twitter"></i>--}}
                {{--<p class="d-lg-none d-xl-none">Twitter</p>--}}
                {{--</a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<div class="wrapper">
    <div class="page-header">
        <div class="page-header-image"></div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6 offset-lg-0 offset-md-3">
                        <div id="square7" class="square square-7"></div>
                        <div id="square8" class="square square-8"></div>
                        <div class="card card-register">
                            <div class="card-header">
                                <img class="card-img" src="{{asset('assets/themes/blk/img/square1.png')}}"
                                     alt="Card image">
                                <h4 class="card-title"> Install</h4>
                            </div>
                            <div class="card-body">
                                <form class="form" href="{{url('/install')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-align-left-2"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="title" value="{{old('title')}}" required
                                               class="form-control" placeholder="网站名称">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-single-02"></i>
                                            </div>
                                        </div>
                                        <input type="text" required name="name" class="form-control"
                                               value="{{{old('name')}}}" placeholder="管理员用户名">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-email-85"></i>
                                            </div>
                                        </div>
                                        <input type="email" name="email" required placeholder="管理员邮箱"
                                               value="{{old('email')}}" class="form-control">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-lock-circle"></i>
                                            </div>
                                        </div>
                                        <input type="password" required name="password" class="form-control"
                                               placeholder="管理员密码">
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            TomatoIDC 通过 GPL3.0 协议开源 ，请遵守 GPL3.0协议
                                        </label>
                                    </div>
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger" style="margin-top: 2rem" role="alert">
                                                {{ $error }}
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-info btn-round btn-lg" value="安装">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="register-bg"></div>
                    <div id="square1" class="square square-1"></div>
                    <div id="square2" class="square square-2"></div>
                    <div id="square3" class="square square-3"></div>
                    <div id="square4" class="square square-4"></div>
                    <div id="square5" class="square square-5"></div>
                    <div id="square6" class="square square-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--   Core JS Files   -->
<script src="{{asset('assets/themes/blk/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/themes/blk/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/themes/blk/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/themes/blk/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('assets/themes/blk/js/plugins/bootstrap-switch.js')}}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{asset('assets/themes/blk/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
<!-- Chart JS -->
<script src="{{asset('assets/themes/blk/js/plugins/chartjs.min.js')}}"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="{{asset('assets/themes/blk/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('assets/themes/blk/js/plugins/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<!-- Black Dashboard DEMO methods, don't include it in your project! -->
<script src="{{asset('assets/themes/blk/demo/demo.js')}}"></script>
<!-- Control Center for Black UI Kit: parallax effects, scripts for the example pages etc -->
<script src="{{asset('assets/themes/blk/js/blk-design-system.min.js?v=1.0.0')}}" type="text/javascript"></script>
</body>

</html>
