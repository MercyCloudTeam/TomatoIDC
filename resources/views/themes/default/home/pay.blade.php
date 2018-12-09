@extends('themes.default.layouts.layout')

@section('content')
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">订单支付</h1>
                        <p class="text-lead text-light">请扫描二维码完成支付</p>
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
                        <div class="text-center text-muted mb-1">
                            <small>请扫描二维码完成支付</small>
                        </div>
                    </div>
                    <div class="text-center mb-3 mt-2">
                        @switch($payPage['type'])
                            @case('qrcode_string')
                            {!! QrCode::size(200)->color(94, 114, 228)->generate($payPage['url']); !!}
                            @break
                            @case('qrcode_base64')
                                <img src="{{$payPage['date']}}">
                            @break
                            @default
                            {{$payPage['date']}}
                            @break
                        @endswitch
                    </div>
                    <div class="text-center">
                        <a href="{{route('order.show')}}" class="btn btn-primary my-4">订单列表</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection