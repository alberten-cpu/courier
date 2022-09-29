@extends('layouts.app.app_layout',['title'=>'Login'])
@section('content')

    @push('styles')
        <style>
            .login-form {
                width: 450px;
                margin: 50px auto;
                font-size: 15px;
                margin-top: 70px;
            }

            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }

            .login-form h2 {
                margin: 25px 0;
                font-size: 24px;
                text-transform: uppercase;
                font-weight: bold;

            }
            .login-form img {
                width: 250px;
                display: block;
                margin-left: auto;
                margin-right: auto;

            }

            .login-form p {
                text-align: center;
            }

            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
            }

            .btn {
                font-size: 15px;
                font-weight: bold;
            }
            .cred
            { margin:35px 0;}
        </style>
    @endpush
    <div class="login-form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <img src="{{asset('admin/img/speedy_logo_png.png')}}" alt="speedy" width="100%" height="100%">
            <h2 class="text-center">{{ __('Customer Portal') }}</h2>
            <p>Please enter your email address and password to login</P>

            <div class="cred">
            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
            </div>
            <div class="clearfix">
                <label class="form-check-label" for="remember">
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember Me') }}
                </label>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
        {{-- <p class="text-center"><a href="{{ route('register') }}">{{ __('Create an Account') }}</a></p> --}}
    </div>
    @push('scripts')
        {{-- Custom JS --}}
    @endpush
@endsection
