@extends('layouts.app')

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrap">
            <div class="card">
                <ul class="navigation-tab">
                    <li class="tab"><a href="/register" class="item">registar</a></li>
                    <li class="tab -active">
                        <span class="item">{{ __('Login') }}</span>
                    </li>
                </ul>

                <div class="card-body">
                    <p class="text-area">Loginすると、ができるようになります。</p>
                    <form method="POST" action="{{ route('login') }}" class="form-style">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 auth-btn-positon">
                                <button type="submit" class="btn btn-primary btn-auth">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                        </div>
                    </form>
                    <div class="form-group row mb-0 auth-btn-positon btn-fb">
                        <a class="btn-sns" href="/login/facebook">
                            <img class="sns-icon" src="/item/fb-icon.png" alt="Light 100">
                            <p class="sign-sns-name">Facebookでログイン</p>
                        </a>
                    </div>
                </div>
            </div>
    </div>
@endsection
