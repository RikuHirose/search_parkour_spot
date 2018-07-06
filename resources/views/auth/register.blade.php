@extends('layouts.app')


<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
            <div class="card">
                <ul class="navigation-tab">
                    <li class="tab -active"><span class="item">{{ __('Register') }}</span></li>
                    <li class="tab">
                        <a href="/login" class="item">login</a>
                    </li>
                </ul>


                <div class="card-body">
                    <p class="text-area">会員登録をすると、ができるようになります。</p>
                    <form method="POST" action="{{ route('register') }}" class="form-style">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0 auth-btn-positon">
                                <button type="submit" class="btn btn-primary btn-auth">
                                    {{ __('Register') }}
                                </button>
                        </div>
                    </form>
                    <div class="or">
                        <p>or</p>
                    </div>
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
