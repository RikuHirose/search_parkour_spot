@extends('layouts.app')


@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
     <div class="user">
            <div class="user-top clearfix">
                <div class="user-img">
                    <?php \App\Helpers\Helper::avatarLogic($user['avatar_name']) ?>
                </div>
                <div class="user-info">
                    <p class="user-posts"><span><?php echo count($content); ?></span>posts</p>
                    <div class="user-btn">
                            <!-- ログインしているuserか判定する -->
                            @auth
                                <?php if (Auth::user()->id != $user['id']): ?>
                                    <p class="action-wrap">aa</p>
                                <?php elseif(Auth::user()->id == $user['id']): ?>
                                    <a class="action-wrap" href="/user/<?php echo $user['id']; ?>/edit">edit profile</a>
                                <?php endif; ?>
                            @endauth
                    </div>
                </div>
            </div>
            <div class="user-bottom">
                <p><?php echo $user['name']; ?></p>
                <p>
                    <?php
                        $string = $user['comment'];
                        $pattern = '/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u';
                        $replacement = '<a href="/search?tag=${1}">#${1}</a>';
                        $replacement2 = '${1}';
                        echo preg_replace($pattern, $replacement, $string);
                    ?>
                </p>
            </div>
            <div class="card-header result-icons">
                <a href="/user/<?php echo $user['id']; ?>" id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
                <a href="/user/<?php echo $user['id']; ?>/map" id="result-map" class="switch-bottom"><i class="fa fa-map-marker-alt fa-3x"></i></a>
            </div>
    </div>

    <div class="content">
        <input type="hidden" value="{{ $user['id'] }}" id="user_id">
        <div id="map_canvas" class="map_canvas"></div>
        <div id="getcurrentlocation" class="get-current">
                <p class="current-p">現在地を取得する</p>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('js/user_index_map.js')}}"></script>
@endsection