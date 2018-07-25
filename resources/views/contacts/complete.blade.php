@extends('layouts.app')

@section('title')
    お問い合わせが完了しました   |
@endsection

@section('css')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
<link href="{{ asset('css/contact.css') }}" rel="stylesheet">
@endsection

@section('content')
 
<div class="wrap">
            <div class="panel panel-default card auth-container">
                <div class="panel-heading">お問い合わせが完了しました</div>
                <a href="/" class="btn btn-primary btn-auth acbtn comple">Topページに戻る</a>
            </div>

</div>
@endsection