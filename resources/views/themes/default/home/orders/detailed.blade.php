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
                                    <span class="heading">{{$order->price}}</span>
                                    <span class="description">价格</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h2>
                            {{$order->good->title ?? "商品已下架"}}<span class="font-weight-light"></span>
                        </h2>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>创建日期: {{$order->created_at->format('M d , Y')}}
                        </div>
                        <hr class="my-4"/>
                        <h2 class="badge badge-dot mr-3">
                            @switch($order->status)
                                @case(1)
                                <i class="bg-warning"></i> 未支付
                                @break
                                @case(2)
                                <i class="bg-success"></i> 已支付
                                @break
                                @case(3)
                                <i class="bg-primary"></i> 审核中
                                @break
                            @endswitch
                        </h2>
                        {{--<a target="_blank" href="{{$host->host_url}}">管理面板</a>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">订单信息</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pl-lg-4 text-center">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-control-label" for="input-username">商品名称</label>
                                <p><strong>{{$order->good->title ?? "商品已下架"}}</strong></p>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-control-label" for="input-username">商品价格</label>
                                <p><strong>{{$order->price}} {{$currencyUnit}}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="pl-lg-4 text-center">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-control-label" for="input-username">创建时间</label>
                                <p><strong>{{$order->created_at->format('M d , Y')}}</strong></p>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-control-label" for="input-username">订单号</label>
                                <p><strong>{{$order->no}}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
