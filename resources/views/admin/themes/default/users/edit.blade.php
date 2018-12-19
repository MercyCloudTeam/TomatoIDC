@extends('admin.themes.default.layouts.app')

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
                    <a href="{{route('home')}}" class="btn btn-info">用户中心</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="{{$user->avatar}}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <span class="heading">{{$user->order->count()}}</span>
                                    <span class="description">订单</span>
                                </div>
                                <div>
                                    <span class="heading">{{$user->account}}</span>
                                    <span class="description">余额</span>
                                </div>
                                <div>
                                    <span class="heading">{{$user->workOrder->count()}}</span>
                                    <span class="description">工单</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            {{$user->name}}<span class="font-weight-light"></span>
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{$user->email}}
                        </div>
                        {{--<div class="h5 mt-4">--}}
                        {{--<i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer--}}
                        {{--</div>--}}
                        {{--<div>--}}
                        {{--<i class="ni education_hat mr-2"></i>University of Computer Science--}}
                        {{--</div>--}}
                        {{--<hr class="my-4" />--}}
                        <p>{{$user->signature}}</p>
                        {{--<a href="#">Show more</a>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">编辑账户</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{action('UserController@userEditAction')}}">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$user->id}}" name="id">
                        <h6 class="heading-small text-muted mb-4">用户信息</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">用户名</label>
                                        <input type="text" id="input-username"
                                               class="form-control form-control-alternative" placeholder="Username"
                                               name="name" value="{{old('name')??$user->name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">邮箱</label>
                                        <input type="email" id="input-email"
                                               class="form-control form-control-alternative" placeholder="Email"
                                               name="email" value="{{old('email')??$user->email}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">QQ</label>
                                        <input type="text" id="input-first-name"
                                               class="form-control form-control-alternative" placeholder="QQ号" name="qq"
                                               value="{{old('qq')??$user->qq}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">电话</label>
                                        <input type="text" id="input-last-name"
                                               class="form-control form-control-alternative" placeholder="电话号码"
                                               name="phone" value="{{old('phone')??$user->phone}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">密码</label>
                                        <input type="text" name="password" id="input-last-name"
                                               class="form-control form-control-alternative" placeholder="不更改则留空"
                                               value="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">余额</label>
                                        <input type="text" name="account" id="input-last-name"
                                               class="form-control form-control-alternative"
                                               value="{{old('account')??$user->account}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <h6 class="heading-small text-muted mb-4">更多信息</h6>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label>关于我</label>
                                <textarea rows="4" class="form-control form-control-alternative" name="signature"
                                          placeholder="座右铭">{{old('signature')??$user->signature}}</textarea>
                            </div>
                        </div>
                        @include('themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="确认">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
