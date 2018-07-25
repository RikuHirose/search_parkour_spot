@extends('layouts.app')

@section('title')
    お問い合わせ   |
@endsection

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
<link href="{{ asset('css/contact.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="wrap">
            <div class="panel panel-default card auth-container">
                <div class="panel-heading">お問い合わせ</div>
                <div class="panel-body">
                    {{-- エラーの表示 --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Form::open(['url' => 'contact/confirm',
                                'class' => 'form-horizontal']) !!}


                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', 'お名前:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', 'メールアドレス:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                        {!! Form::label('body', '内容:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('body'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {!! Form::submit('確認', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
</div>
@endsection