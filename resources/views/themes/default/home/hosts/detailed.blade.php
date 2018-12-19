@extends('themes.default.layouts.home')

@section('content')

    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
         style="min-height: 600px; background-image: url({{asset('assets/themes/argon/img/computer-1149148.jpg')}}); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <p class="text-white" style="font-size: 1rem">欢迎回来</p>
                    <h1 class="display-2 text-white">{{Auth::user()->name}}</h1>
                    <p class="text-white mt-0 mb-5">祝你开心每一天！</p>
                    <a href="{{route('host.show')}}" class="btn btn-info">产品管理</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card">
                <h1 class="display-3 text-center mt-5 mb--2">信息卡</h1>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading">{{$host->order->price}}</span>
                                    <span class="description">价格</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h2>
                            {{$host->order->good->title}}<span class="font-weight-light"></span>
                        </h2>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{$host->host_panel}}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>账户名 : {{$host->host_name}}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>密码 : {{$host->host_pass}}
                        </div>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>创建日期: {{$host->created_at->format('M d , Y')}}
                        </div>
                        <hr class="my-4"/>
                        <button class="btn btn-primary" type="button"
                                onclick="event.preventDefault();
                                document.getElementById('host-panel-{{$host->id}}').submit();"
                                href="{{$host->host_url}}">管理面板
                        </button>
                        <form id="host-panel-{{$host->id}}"
                              action="{{ route('host.panel.login') }}" method="POST"
                              style="display: none;">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$host->id}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">主机信息</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection
