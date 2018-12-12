@extends('themes.default.layouts.app')
@section('content')
    <main>
        <section class="section section-shaped section-lg">
            <div class="shape shape-style-1 bg-gradient-default">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="container pt-lg-md">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card bg-secondary shadow border-0">
                            <div class="card-header bg-white pb-5">
                                <div class="text-muted text-center mb-3">
                                    <small>第三方注册</small>
                                </div>
                                <div class="text-center">
                                    {{--<a href="#" class="btn btn-neutral btn-icon mr-4">--}}
                    {{--<span class="btn-inner--icon">--}}
                      {{--<img src="{{asset('assets/themes/argon/img/icons/common/github.svg')}}">--}}
                    {{--</span>--}}
                                        {{--<span class="btn-inner--text">Github</span>--}}
                                    {{--</a>--}}
                                    <a href="#" onclick="alert('未开放')" class="btn btn-neutral btn-icon">
                    <span class="btn-inner--icon">
                      <img src="{{asset('assets/themes/argon/img/icons/common/google.svg')}}">
                    </span>
                                        <span class="btn-inner--text">Google</span>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body px-lg-5 py-lg-5">
                                <div class="text-center text-muted mb-4">
                                    <small>邮箱注册</small>
                                </div>
                                <form role="form" method="post" action="{{ route('register') }}">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Email"  name="email"  type="email" value="{{ old('email') }}" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Password" type="password" name="password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Confirm Password" type="password" name="password_confirmation" required >
                                        </div>
                                    </div>
                                    {{--<div class="text-muted font-italic">--}}
                                    {{--<small>password strength:--}}
                                    {{--<span class="text-success font-weight-700">strong</span>--}}
                                    {{--</small>--}}
                                    {{--</div>--}}
                                    <div class="row my-4">
                                        <div class="col-12">
                                            <div class="custom-control custom-control-alternative custom-checkbox">
                                                <input class="custom-control-input" id="customCheckRegister" checked name="agreement" type="checkbox">
                                                <label class="custom-control-label" for="customCheckRegister">
                                                    <span>我同意
                                                    <a href="{{$userAgreements}}">服务协议</a>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @include('themes.default.layouts.errors')
                                    <div class="text-center">
                                        <input type="submit" class="btn btn-primary my-4" value="注册">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
