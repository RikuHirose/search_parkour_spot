@extends('layouts.app')


@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <div class="user">
        <div class="user-top clearfix">
            <div class="user-img">
                <?php if($user['avatar_name'] == ''): ?>
                    <img src="/item/default-icon.png" class="avatar_name">
                <?php else: ?>
                    @if (App\Helpers\Helper::isFB($user['avatar_name']) == true)
                        <img src="{{ $user['avatar_name'] }}" class="avatar_name">
                    @else
                        <img src="/item/user/{{ $user['avatar_name'] }}" class="avatar_name">
                    @endif
                <?php endif; ?>
            </div>
            <div class="user-info">
                <p><span>{{ count($content) }}</span>posts</p>
                <div class="user-btn">
                    <a href="">
                        <!-- ログインしているuserか判定する -->
                        @guest
                            <p>aa</p>
                        @else
                            <a href="/user/{{ $user['id'] }}/edit">edit profile</a>
                        @endguest
                    </a>
                </div>
            </div>
        </div>
        <div class="user-bottom">
            <p>{{ $user['name'] }}</p>
            <p>{{ $user['comment'] }}</p>
        </div>
        <div>
            <a href="/user/{{ $user['id'] }}">index</a>
            <a href="/user/{{ $user['id'] }}/map">map</a>
        </div>
    </div>
    <div class="content">
        <input type="hidden" value="{{ $user['id'] }}" id="user_id">
        <div id="map_canvas" class="map_canvas"></div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('js/user_index_map.js')}}"></script>
@endsection