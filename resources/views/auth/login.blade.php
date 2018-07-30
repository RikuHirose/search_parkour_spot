@extends('layouts.app')

@section('title')
    ログインする   |
@endsection

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="wrap">
            <?php if(App\Helpers\Helper::isMobile() == false): ?>
                <div class="card auth-container">

                    <ul class="navigation-tab">
                        <li class="tab"><a href="/register" class="item">会員登録</a></li>
                        <li class="tab -active">
                            <span class="item">ログイン</span>
                        </li>
                    </ul>

                    <div class="card-body">
                        <!-- <p class="text-area">すでにpkLinksアカウントをお持ちの方は、こちらからログインしてご利用ください。</p> -->

                        <!-- <div class="form-group row mb-0 auth-btn-positon  btn-auth new-res acbtn">
                            <a class="btn-sns " href="/register">
                                <p class="new-resbtn">無料新規会員登録</p>
                            </a>
                        </div> -->

                        <div class="form-group row mb-0 auth-btn-positon btn-fb btn-auth acbtn">
                            <a class="btn-sns" href="/login/facebook">
                                <img class="sns-icon" src="/item/fb-icon.png" alt="Light 100">
                                <p class="sign-sns-name">Facebookでログイン</p>
                            </a>
                        </div>
                        <p class="title-or">または</p>
                        <form method="POST" action="{{ route('login') }}" class="form-style">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-poss" name="email" value="{{ old('email') }}" required autofocus placeholder="メールアドレス">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-poss" name="password" required placeholder="パスワード">

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
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} checked="checked">
                                            ログイン状態を保持する
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 auth-btn-positon">
                                <button type="submit" class="btn btn-primary btn-auth acbtn" data-disable-with="処理中...">
                                    {{ __('Login') }}
                                </button>
                            </div>
                            <div class="form-group row mb-0 auth-btn-positon">
                                <a class="btn btn-link forgetpass" href="{{ route('password.request') }}">
                                    パスワードをお忘れの方はこちら
                                </a>
                            </div>
                        </form>
                        <p class="text-area text-area2">アカウントをお持ちでない方はこちらから<a class="btn-sns " href="/register">会員登録</a></p>
                    </div>
                </div>
        <?php elseif(App\Helpers\Helper::isMobile() == true): ?>
                <div class="card">
                    <ul class="navigation-tab">
                    <li class="tab"><a href="/register" class="item">会員登録</a></li>
                    <li class="tab -active">
                        <span class="item">ログイン</span>
                    </li>
                </ul>

                <div class="card-body">
                    <!-- <p class="text-area">すでにpkLinksアカウントをお持ちの方は、こちらからログインしてご利用ください。</p> -->
                    <p class="text-area">アカウントをお持ちでない方はこちらから</p>
                        <div class="form-group row mb-0 auth-btn-positon new-res acbtn">
                            <a class="btn-sns " href="/register">
                                <p class="new-resbtn">無料新規会員登録</p>
                            </a>
                        </div>

                    <div class="form-group row mb-0 auth-btn-positon btn-fb acbtn">
                        <a class="btn-sns" href="/login/facebook">
                            <img class="sns-icon" src="/item/fb-icon.png" alt="Light 100">
                            <p class="sign-sns-name">Facebookでログイン</p>
                        </a>
                    </div>
                    <p class="title-or">または</p>
                    <form method="POST" action="{{ route('login') }}" class="form-style">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="メールアドレス">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="パスワード">

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
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} checked="checked">
                                        ログイン状態を保持する
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 auth-btn-positon">
                            <button type="submit" class="btn btn-primary btn-auth acbtn" data-disable-with="処理中...">
                                ログイン
                            </button>
                        </div>
                        <div class="form-group row mb-0 auth-btn-positon">
                            <a class="btn btn-link forgetpass" href="{{ route('password.request') }}">
                                パスワードをお忘れの方はこちら
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
@endsection
