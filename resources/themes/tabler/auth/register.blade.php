@extends('theme::layouts.guest')

@section('content')

    <div class="container-tight py-4">
        <div class="text-center mb-4">
            <a href="."><img src="./static/logo.svg" height="36" alt=""></a>
        </div>
        <form class="card card-md" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Create new account</h2>
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" value="{{old('name')}}"  name="name" placeholder="Enter name">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control"  value="{{old('email')}}"  name="email" placeholder="Enter email">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Password') }}</label>
                    <div class="input-group input-group-flat">
                        <input type="password" class="form-control" name="password" value="{{old('password')}}"  placeholder="Password"  autocomplete="off">
                        <span class="input-group-text">
                  <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                  </a>
                </span>
                    </div>
                </div>
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-3">
                    <label class="form-check">
                        <input checked name="terms" id="terms" type="checkbox" class="form-check-input"/>
                        <span class="form-check-label"> {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}</span>
                    </label>
                </div>
                @endif
                @include('theme::common.errors')
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100"> {{ __('Register') }}</button>
                </div>
            </div>
        </form>
        <div class="text-center text-muted mt-3">
             <a href="{{ route('login') }}" tabindex="-1">{{ __('Already registered?') }}</a>
        </div>
    </div>
@endsection
