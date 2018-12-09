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
        <div class="col-xl-8 order-xl-1  mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">账户充值</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('user.recharge.pay')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{--oninput="value=value.replace(/[^\d]/g,'')"--}}
                                    <label class="form-control-label" for="input-first-name">充值金额</label>
                                    <input  type="text" id="input-first-name"
                                           name="money" oninput="value=value.replace(/[^\d]/g,'')"
                                            class="form-control form-control-alternative">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-control-label" for="input-last-name">订单支付方式</label>
                                @if(!empty($paymentWechat))
                                    <div class="custom-control custom-radio mb-3">
                                        <input class="custom-control-input" id="customRadio6" name="payment" checked
                                               value="wechat" type="radio">
                                        <label class="custom-control-label" for="customRadio6">微信支付</label>
                                    </div>
                                @endif
                                @if(!empty($paymentAlipay))
                                    <div class="custom-control custom-radio mb-3">
                                        <input class="custom-control-input" id="customRadio5" name="payment" checked
                                               value="alipay" type="radio">
                                        <label class="custom-control-label" for="customRadio5">支付宝</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{--@include('themes.default.layouts.errors')--}}
                        <input type="submit" class="btn btn-primary" value="支付">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">卡密激活</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('prepaid.key')}}">
                        {{csrf_field()}}
                        {{--<input type="hidden" name="id" value="{{$good->id}}">--}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-first-name">Key</label>
                                    <input type="text" id="input-first-name" name="key"
                                           class="form-control form-control-alternative">
                                </div>
                            </div>
                        </div>
                        @include('themes.default.layouts.alert')
                        <input type="submit" class="btn btn-primary" value="充值">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
