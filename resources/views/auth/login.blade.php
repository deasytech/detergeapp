@extends('layouts.app')
@section('styles')
  <style>
  html,body {height: 100%;}
  body {display: -ms-flexbox;display: flex;-ms-flex-align: center;align-items: center;padding-top: 40px;padding-bottom: 40px;}
  </style>
@endsection
@section('content')
  <div class="splash-container">
    <div class="card ">
      <div class="card-header text-center"><a href="/"><img class="logo-img" src="{{ asset('images/logo.png') }}" alt="{{ __('Login') }}"></a><span class="splash-description">Please enter your user information.</span></div>
      <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <input class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="{{ __('E-Mail Address') }}" autocomplete="email" value="{{ old('email') }}" required autofocus>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" type="password" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">
                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="form-group">
                <label class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span class="custom-control-label">{{ __('Remember Me') }}</span>
                </label>
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
            </form>
          </div>
          <div class="card-footer bg-white p-0">
              <div class="card-footer-item card-footer-item-bordered">
                @if (Route::has('password.request'))
                  <a class="footer-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                  </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endsection
