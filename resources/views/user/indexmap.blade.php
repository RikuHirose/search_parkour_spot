@extends('layouts.app')


@section('title')
    <?php echo $user['name']; ?>   |
@endsection

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <?php if(App\Helpers\Helper::isMobile() == true): ?>
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
                                                    <input type="submit" id="delete-follow-{{ $user['id'] }}" class="notme _8A5w5" value="フォロー中">
                                                </form>
                                        @else
                                                <form action="{{route('follow', ['id' => $user['id'] ]) }}" method="POST" class="">
                                                    {{ csrf_field() }}
                                                    <input type="submit" id="follow-user-{{ $user['id'] }}" class="notme L3NKy" value="フォローする">
                                                </form>
                                        @endif
                                    <?php elseif(Auth::user()->id == $user['id']): ?>
                                        <a  href="/user/<?php echo $user['id']; ?>/edit">
                                            <button class="action-wrap ">edit profile</button>
                                        </a>
                                        <i class="fas fa-cog fa-3x modal-open logout-iconpos"></i>
                                        <div id="modal">
                                            <div class="iziModal-content">
                                                <a data-izimodal-close="" class="modal-close">×</a>
                                                <!-- modal -->
                                                <div class="select-modal delmodal">
                                                   <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                @endauth
                                @guest
                                <span class="modal-open">
                                    <button class="notme">フォローする</button>
                                </span>
                                 <div id="modal">
                                    <div class="iziModal-content">
                                        <a data-izimodal-close="" class="modal-close">×</a>
                                        <!-- modal -->
                                        <div class="select-modal needregistar">
                                           <p class="">このユーザーをフォローするには会員登録が必要です。</p>
                                                <a  class="btn btn-primary btn-auth acbtn letregid" href="/register">会員登録する(無料)</a>
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
                        <?php echo App\Helpers\Helper::commentTotag($user['comment']); ?>
                    </p>
                </div>
                <div class="card-header result-icons">
                    <a href="/user/<?php echo $user['id']; ?>" id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
                    <a href="/user/<?php echo $user['id']; ?>/map" id="result-map" class="switch-bottom switch-left"><i class="fa fa-map-marker-alt fa-3x"></i></a>
                    @auth
                        <?php if (Auth::user()->id == $user['id']): ?>
                            <a href="/user/<?php echo $user['id']; ?>/liked">
                                <i class="fas fa-heart fa-3x"></i>
                            </a>
                        <?php endif; ?>
                    @endauth
                </div>
        </div>
    <?php elseif(App\Helpers\Helper::isMobile() == false): ?>
        <div class="user">
                <div class="user-top clearfix">
                    <div class="user-img">
                        <?php \App\Helpers\Helper::avatarLogic($user['avatar_name']) ?>
                    </div>
                    <div class="user-info">

                        <div class="user-btn">
                                <!-- ログインしているuserか判定する -->
                                @auth
                                    <?php if (Auth::user()->id != $user['id']): ?>
                                        @if (auth()->user()->isFollowing($user['id']))
                                                <form action="{{route('unfollow', ['id' => $user['id'] ]) }}" method="POST" class="">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <input type="submit" id="delete-follow-{{ $user['id'] }}" class="action-wrap2 _8A5w5" value="フォロー中">
                                                </form>
                                        @else
                                                <form action="{{route('follow', ['id' => $user['id'] ]) }}" method="POST" class="">
                                                    {{ csrf_field() }}
                                                    <input type="submit" id="follow-user-{{ $user['id'] }}" class="action-wrap2 L3NKy" value="フォローする">
                                                </form>
                                        @endif
                                    <?php elseif(Auth::user()->id == $user['id']): ?>
                                        <a  href="/user/<?php echo $user['id']; ?>/edit">
                                            <button class="action-wrap2">edit profile</button>
                                        </a>
                                        <i class="fas fa-cog fa-3x modal-open logout-iconpos"></i>
                                        <div id="modal">
                                            <div class="iziModal-content">
                                                <a data-izimodal-close="" class="modal-close">×</a>
                                                <!-- modal -->
                                                <div class="select-modal delmodal">
                                                   <a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                @endauth
                                @guest
                                <span class="modal-open">
                                    <button class="action-wrap2">フォローする</button>
                                </span>
                                 <div id="modal">
                                    <div class="iziModal-content">
                                        <a data-izimodal-close="" class="modal-close">×</a>
                                        <!-- modal -->
                                        <div class="select-modal needregistar">
                                           <p class="">このユーザーをフォローするには会員登録が必要です。</p>
                                                <a  class="btn btn-primary btn-auth acbtn letregid" href="/register">会員登録する(無料)</a>
                                        </div>
                                    </div>
                                </div>
                                @endguest
                        </div>
                        <h2 class="user-name-h2" ><?php echo $user['name']; ?></h2>
                        <ul class="ul-lis">
                            <li class="user-posts">
                                <span><?php echo count($content); ?></span>posts</p>
                            </li>
                            <li>
                                <a class="user-followers" href="/user/{{ $user['id'] }}/followerlist">
                                    <span><?php echo count($followers); ?></span>followers
                                </a>
                            </li>
                            <li>
                                <a class="user-follows" href="/user/{{ $user['id'] }}/followlist">
                                    <span><?php echo count($follows); ?></span>follows
                                </a>
                            </li>

                        </ul>
                        <p class="user-cim"><?php echo App\Helpers\Helper::commentTotag($user['comment']); ?></p>
                    </div>
                </div>
                <div class="card-header result-icons">
                    <a href="/user/<?php echo $user['id']; ?>" id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
                    <a href="/user/<?php echo $user['id']; ?>/map" id="result-map" class="switch-left switch-bottom"><i class="fa fa-map-marker-alt fa-3x"></i></a>
                    @auth
                        <?php if (Auth::user()->id == $user['id']): ?>
                            <a href="/user/<?php echo $user['id']; ?>/liked">
                                <i class="fas fa-heart fa-3x"></i>
                            </a>
                        <?php endif; ?>
                    @endauth
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
<script src="{{asset('js/user_index_map.js')}}"></script>
<script src="{{asset('js/iziModal.min.js')}}"></script>
@endsection