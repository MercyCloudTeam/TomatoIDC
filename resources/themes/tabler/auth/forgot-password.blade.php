@extends('theme::layouts.guest')

@section('content')

    <div class="container-tight py-4">
        <div class="text-center mb-4">
            <a href="."><img src="./static/logo.svg" height="36" alt=""></a>
        </div>
        <form class="card card-md" method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</h2>

                @if (session('status'))
                    <div class="alert alert-info" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-title">{{__('Status')}}</h4>
                                <div class="text-muted"> {{ session('status') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 font-medium text-sm text-green-600">
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control"  value="{{old('email', $request->email)}}" required autofocus name="email" placeholder="Enter email">
                </div>
                @include('theme::common.errors')
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Email Password Reset Link') }}</button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
            <a href="{{ route('login') }}" tabindex="-1">{{ __('Already registered?') }}</a>
        </div>
    </div>
@endsection
