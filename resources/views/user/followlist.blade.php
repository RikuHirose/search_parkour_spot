@extends('layouts.app')

@section('title')
    フォローしたユーザー一覧   |
@endsection

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <div class="clearfix content-top">
    	<?php App\Helpers\Helper::SideUserList($follow); ?>
        
    </div>
</div>

@endsection

@section('js')

@endsection