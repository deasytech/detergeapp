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
      <div class="card-header text-center"><a href="/"><img class="logo-img" src="{{asset('images/logo.png')}}" alt="{{ __('Register') }}"></a><span class="splash-description">Please enter user information to register.</span></div>
      <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="form-group">
            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Names') }}">

              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <input class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" type="email" placeholder="{{ __('E-Mail Address') }}" autocomplete="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="form-group">
                <input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" type="password" placeholder="{{ __('Password') }}" name="password" required autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                </div>
                <div class="form-group">
                  <label class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox"><span class="custom-control-label">By creating an account, you agree the <a href="#">terms and conditions</a></span>
                  </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('Register') }}</button>
              </form>
            </div>
            <div class="card-footer bg-white">
              <p>Already member? <a href="{{ route('login') }}" class="text-secondary">{{ __('Login') }}</a></p>
            </div>
          </div>
        </div>
      @endsection
