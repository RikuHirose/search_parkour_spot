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
                    <a class="user-followers" href="/user/{{ $user['id'] }}/followerlist">
                        <span><?php echo count($followers); ?></span>followers
                    </a>
                    <a class="user-follows" href="/user/{{ $user['id'] }}/followlist">
                        <span><?php echo count($follows); ?></span>follows
                    </a>
                    <div class="user-btn">
                            <!-- ログインしているuserか判定する -->
                            @auth
                                <?php if (Auth::user()->id != $user['id']): ?>
                                        @if (auth()->user()->isFollowing($user['id']))
                                                <form action="{{route('unfollow', ['id' => $user['id'] ]) }}" method="POST" class="">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <input type="submit" id="delete-follow-{{ $user['id'] }}" class="action-wrap" value="Unfollow">
                                                </form>
                                        @else
                                                <form action="{{route('follow', ['id' => $user['id'] ]) }}" method="POST" class="">
                                                    {{ csrf_field() }}
                                                    <input type="submit" id="follow-user-{{ $user['id'] }}" class="action-wrap" value="Follow">
                                                </form>
                                        @endif
                                <?php elseif(Auth::user()->id == $user['id']): ?>
                                    <a  href="/user/<?php echo $user['id']; ?>/edit">
                                        <button class="action-wrap">edit profile</button>
                                    </a>
                                <?php endif; ?>

                            @endauth
                            @guest
                            <span class="modal-open">
                                <button class="action-wrap">フォローする</button>
                            </span>
                             <div id="modal">
                                <div class="iziModal-content">
                                    <a data-izimodal-close="">×</a>
                                    <!-- modal -->
                                    <div class="select-modal">
                                       <a href="/login">you need login</a>
                                    </div>
                                </div>
                            </div>
                            @endguest
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
@guest
        <script src="{{asset('js/iziModal.min.js')}}"></script>
@endguest
@endsection