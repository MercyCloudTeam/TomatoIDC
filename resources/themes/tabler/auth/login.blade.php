@extends('theme::layouts.guest')

@section('content')
    <div class="container-tight py-4">
        <div class="text-center mb-4">
            <a href="."><img src="./static/logo.svg" height="36" alt=""></a>
        </div>
        <form class="card card-md"  action="{{ route('login') }}" method="get" autocomplete="off">
            @csrf
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login to your account</h2>
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email"  name="email" value="{{old('email')}}" required autofocus class="form-control" placeholder="{{__('Your Email')}}">
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        {{ __('Password') }}
                        <span class="form-label-description">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            @endif
                </span>
                    </label>
                    <div class="input-group input-group-flat">
                        <input type="password" name="password" required  class="form-control"  placeholder="Password"  autocomplete="current-password">
                        <span class="input-group-text">
                  <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                  </a>
                </span>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input"/>
                        <span class="form-check-label">{{ __('Remember me') }}</span>
                    </label>
                </div>
                @include('theme::common.errors')
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100"> {{ __('Log in') }}</button>
                </div>
            </div>
            <div class="hr-text">or</div>
            <div class="card-body">
{{--                <div class="row">--}}
{{--                    <div class="col"><a href="#" class="btn btn-white w-100">--}}
{{--                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-github" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" /></svg>--}}
{{--                            Login with Github--}}
{{--                        </a></div>--}}
{{--                    <div class="col"><a href="#" class="btn btn-white w-100">--}}
{{--                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-twitter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c-.002 -.249 1.51 -2.772 1.818 -4.013z" /></svg>--}}
{{--                            Login with Twitter--}}
{{--                        </a></div>--}}
{{--                </div>--}}
            </div>
        </form>
        <div class="text-center text-muted mt-3">
           {{ __(" Don't have account yet?") }} <a href="{{route('register')}}" tabindex="-1">{{ __('Sign up') }}</a>
        </div>
    </div>
@endsection
