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
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-9 order-xl-1 mb-3">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">订购商品</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <h6 class="heading-small text-muted mb-4">订单信息</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">商品名称</label>
                                        <input type="text" id="input-username"
                                               class="form-control form-control-alternative" disabled
                                               value="{{$order->good->title}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">价格</label>
                                        <input type="text" id="input-email"
                                               class="form-control form-control-alternative" disabled
                                               value="{{$order->price}}  {{$currencyUnit}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">优惠码</label>
                                        <input type="text" id="input-first-name"
                                               class="form-control form-control-alternative" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">推荐者</label>
                                        <input type="text" id="input-last-name"
                                               class="form-control form-control-alternative" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-3 order-xl-2 mb-5 mb-xl-0">
            <div class="card bg-secondary shadow">
                <div class="text-center mt-5">
                    @switch($payPage['type'])
                        @case('qrcode')
                        {!! QrCode::size(200)->color(94, 114, 228)->generate($payPage['url']); !!}
                        @break
                        @case('redirect')
                        {{--                         {{redirect($payPage['url'])}}--}}
                        @break
                    @endswitch

                </div>
                <div class="card-body text-center">
                    <h5 class="card-title text-center">扫描二维码付款</h5>
                    <p class="card-text text-center">支付完成<br>请点击下面按钮查询订单状态</p>
                    <a href="" onclick="event.preventDefault();
                         document.getElementById('check-order-status').submit();"
                       class="text-center btn btn-primary">刷新</a>
                    <form id="check-order-status" action="{{ route('order.status') }}" method="POST"
                          style="display: none;">
                        <input type="hidden" name="no" value="{{$order->no}}">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
