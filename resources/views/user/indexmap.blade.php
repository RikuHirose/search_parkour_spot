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
                    <img src="/item/user-default.png" class="avatar_name">
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
                        <!-- ログインしているuserか判定する -->
                        @auth
                            <?php if (Auth::user()->id != $user['id']): ?>
                                <p>aa</p>
                            <?php elseif(Auth::user()->id == $user['id']): ?>
                                <a href="/user/{{ $user['id'] }}/edit">edit profile</a>
                            <?php endif; ?>
                        @endauth
                </div>
            </div>
        </div>
        <div class="user-bottom">
            <p>{{ $user['name'] }}</p>
            <p>{{ $user['comment'] }}</p>
        </div>
        <div class="card-header result-icons">
            <a href="/user/{{ $user['id'] }}" id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
            <a href="/user/{{ $user['id'] }}/map" id="result-map" class="switch-bottom"><i class="fa fa-map-marker-alt fa-3x"></i></a>
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