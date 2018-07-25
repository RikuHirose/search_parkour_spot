@extends('layouts.app')

@section('title')
    いいねした投稿一覧   |
@endsection

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <?php if(App\Helpers\Helper::isMobile() == true): ?>
        <div class="user">
                <div class="user-top clearfix nosee">
                    <p>「いいね!」した投稿です。他の人には表示されません。</p>
                </div>
                <div class="card-header result-icons">
                    <a href="/user/<?php echo $user['id']; ?>/liked" id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
                    <a href="/user/<?php echo $user['id']; ?>/liked/map" id="result-map" class="switch-bottom" ><i class="fa fa-map-marker-alt fa-3x"></i></a>
                </div>
        </div>
    <?php elseif(App\Helpers\Helper::isMobile() == false): ?>
        <div class="user">
                <div class="user-top clearfix nosee">
                    <p>「いいね!」した投稿です。他の人は表示されません。</p>
                </div>
                <div class="card-header result-icons">
                    <a href="/user/<?php echo $user['id']; ?>/liked" id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
                    <a href="/user/<?php echo $user['id']; ?>/liked/map" id="result-map" class="switch-bottom"><i class="fa fa-map-marker-alt fa-3x"></i></a>
                </div>
        </div>
    <?php endif; ?>

    <div class="content">
        <input type="hidden" value="{{ $user['id'] }}" id="user_id">
        <div id="map_canvas" class="map_canvas"></div>
        <div id="getcurrentlocation" class="get-current">
                <p class="current-p acbtn">現在地を取得する</p>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('js/likedMap.js')}}"></script>
<script src="{{asset('js/iziModal.min.js')}}"></script>
@endsection