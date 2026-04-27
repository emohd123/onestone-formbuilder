@php
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
    $user = Auth::user();
@endphp
@extends('layouts.app')
@section('title', __('Sign in'))
@section('content')
    <style>
        $white: #fff;
        $google-blue: #4285f4;
        $button-active-blue: #1669F2;

        .google-btn {
            width: 184px;
            height: 42px;
            background-color: $google-blue;
            border-radius: 2px;
            box-shadow: 0 3px 4px 0 rgba(0,0,0,.25);
        .google-icon-wrapper {
            position: absolute;
            margin-top: 1px;
            margin-left: 1px;
            width: 40px;
            height: 40px;
            border-radius: 2px;
            background-color: $white;
        }
        .google-icon {
            position: absolute;
            margin-top: 11px;
            margin-left: 11px;
            width: 18px;
            height: 18px;
        }
        .btn-text {
            float: right;
            margin: 11px 11px 0 0;
            color: $white;
            font-size: 14px;
            letter-spacing: 0.2px;
            font-family: "Roboto";
        }
        &:hover {
             box-shadow: 0 0 6px $google-blue;
         }
        &:active {
             background: $button-active-blue;
         }
        }

        @import url(https://fonts.googleapis.com/css?family=Roboto:500);
    </style>
    <div class="login-content-inner">
        <div class="login-title">
            <h3>{{ __('Sign In') }}</h3>
        </div>
        <form method="POST" data-validate action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                <input type="email" id="email" class="form-control" placeholder="{{ __('Enter email address') }}"
                    name="email" tabindex="1" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">{{ __('Enter Password') }}</label>
                <a href="{{ route('password.request') }}" class="float-end forget-password">
                    {{ __('Forgot Password ?') }}
                </a>
                <input id="password" type="password" class="form-control" placeholder="{{ __('Enter password') }}"
                    name="password" tabindex="2" required autocomplete="current-password">
            </div>
            @if (Utility::getsettings('login_recaptcha_status') == '1')
                <div class="my-3 text-center">
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                </div>
            @endif
            <div class="d-grid">
                <button type="submit" class="btn">{{ __('Sign In') }}</button>
            </div>
        </form>
        @if (Utility::getsettings('GOOGLESETTING') == 'on' ||
                Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                Utility::getsettings('GITHUBSETTING') == 'on' ||
                Utility::getsettings('LINKEDINSETTING') == 'on')
            <div class="register-option">
                <p>{{ __('or Login / Register with Google') }}</p>
            </div>
        @endif
        <div class="social-media-icon">
            @if (Utility::getsettings('GOOGLESETTING') == 'on' ||
                    Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                    Utility::getsettings('GITHUBSETTING') == 'on')
                <div class="mt-1 mb-4 row">
                    <div class="register-btn-wrapper">
                        @if (Utility::getsettings('GOOGLESETTING') == 'on')
                            <div class="">
                                <div class="d-grid">
                                    <a href="{{ url('/redirect/google') }}" class="btn btn-light" style="border: none">
                                        {!! Form::image(asset('assets/images/auth/img-google.svg'), null, ['class' => 'img-fluid wid-25' ,  'style' => 'border: none;']) !!}

                                    </a>

                                </div>
                            </div>
                        @endif
                        @if (Utility::getsettings('FACEBOOKSETTING') == 'on')
                            <div class="col-4">
                                <div class="d-grid">
                                    <a href="{{ url('/redirect/facebook') }}" class="btn btn-light">
                                        {!! Form::image(asset('assets/images/auth/img-facebook.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (Utility::getsettings('GITHUBSETTING') == 'on')
                            <div class="col-4">
                                <div class="d-grid">
                                    <a href="{{ url('/redirect/github') }}" class="btn btn-light">
                                        {!! Form::image(asset('assets/images/auth/github.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
