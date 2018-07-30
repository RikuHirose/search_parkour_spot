@extends('layouts.app')


@section('title')
    会員登録する   |
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
                    <li class="tab -active"><span class="item">会員登録</span></li>
                    <li class="tab">
                        <a href="/login" class="item">ログイン</a>
                    </li>
                </ul>


                <div class="card-body">
                    <p class="text-area">会員登録をすると、投稿をいいねしたり、他のユーザーをフォローすることができるようになります。</p>

                        <div class="form-group row mb-0 auth-btn-positon btn-fb btn-auth acbtn">
                            <a class="btn-sns" href="/login/facebook">
                                <img class="sns-icon" src="/item/fb-icon.png" alt="Light 100">
                                <p class="sign-sns-name">Facebookで登録</p>
                            </a>
                        </div>
                    <p class="title-or">または</p>
                    <form method="POST" action="{{ route('register') }}" class="form-style">
                        @csrf

                        <div class="form-group row ">
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-poss form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="お名前">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-poss form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="メールアドレス">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-poss form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="パスワード">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-poss form-control form-posslast" name="password_confirmation" required placeholder="パスワード(確認用)">
                            </div>
                        </div>

                        <div class="form-group row mb-0 auth-btn-positon">
                                <button type="submit" class="btn btn-primary btn-auth acbtn">
                                    登録する
                                </button>
                        </div>
                    </form>
                    <p class="text-area text-area2">既にアカウントをお持ちの方はこちらから<a href="/login">ログイン</a></p>

                </div>
            </div>
            <?php elseif(App\Helpers\Helper::isMobile() == true): ?>
                <div class="card">
                    <ul class="navigation-tab">
                        <li class="tab -active"><span class="item">会員登録</span></li>
                        <li class="tab">
                            <a href="/login" class="item">ログイン</a>
                        </li>
                    </ul>


                    <div class="card-body">
                        <p class="text-area">会員登録をすると、投稿をいいねしたり、他のユーザーをフォローすることができるようになります。</p>

                            <div class="form-group row mb-0 auth-btn-positon btn-fb">
                                <a class="btn-sns" href="/login/facebook">
                                    <img class="sns-icon" src="/item/fb-icon.png" alt="Light 100">
                                    <p class="sign-sns-name">Facebookでログイン</p>
                                </a>
                            </div>
                        <p class="title-or">または</p>
                        <form method="POST" action="{{ route('register') }}" class="form-style">
                            @csrf

                            <div class="form-group row ">
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="お名前">

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">

                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="メールアドレス">

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
                                <div class="col-md-6">

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="パスワード(確認用)">
                                </div>
                            </div>

                            <div class="form-group row mb-0 auth-btn-positon">
                                    <button type="submit" class="btn btn-primary btn-auth">
                                        会員登録
                                    </button>
                            </div>
                        </form>

                    </div>
                </div>
            <?php endif; ?>
</div>
@endsection
