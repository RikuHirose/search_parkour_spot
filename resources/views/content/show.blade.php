@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}"/>
<link href="{{ asset('css/show.css') }}" rel="stylesheet">
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="wrap">
            <div class="card">
                <?php if(App\Helpers\Helper::isMobile() == true): ?>
                    <div class="card-header">
                        @foreach ($user as $v)
                            <a href="/user/{{ $v['id'] }}">
                                @if($v['avatar_name'] == '')
                                    <img src="/item/user-default.png" class="avatar_name">
                                @else
                                    @if (App\Helpers\Helper::isFB($v['avatar_name']) == true)
                                        <img src="{{ $v['avatar_name'] }}" class="avatar_name">
                                    @else
                                        <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/{{ $v['avatar_name'] }}" class="avatar_name">
                                        <!-- <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/{{ $v['avatar_name'] }}" class="avatar_name"> -->
                                    @endif
                                @endif
                                {{ $v['name'] }}
                            </a>
                            @if (Auth::check())
                                @if (App\Helpers\Helper::isUser($v['id']) == true)
                                    <i class="fas fa-align-right modal-open  acbtn del-open"></i>
                                    <div id="modal">
                                        <div class="iziModal-content">
                                            <a data-izimodal-close="" class="modal-close">×</a>
                                            <!-- modal -->
                                            <div class="select-modal">
                                                <!-- delete -->
                                                <button type="button" class="btn btn-default" id="content_delete">
                                                    {!! Form::open(['url' => '/content/'.$content['id'], 'method' => 'delete', 'onSubmit' => 'return check()']) !!}

                                                        {!! Form::hidden('id',$content['id']) !!}
                                                        {!! Form::submit('delete',['class' => 'btn btn-default', 'name' => 'btn']) !!}

                                                    {!! Form::close() !!}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- <a href="javascript:history.back()" class="history-back"><i class="fas fa-undo fa-2x"></i></a> -->
                                @endif
                            @endif
                        @endforeach
                    </div>
                <?php endif; ?>
                <div class="container" id="content-block">
                    <div class="row content-position">
                        <div class="col-md-8">
                            <?php if(App\Helpers\Helper::isMobile() == false): ?>
                                <div class="card-header">
                                @foreach ($user as $v)
                                    <a href="/user/{{ $v['id'] }}">
                                        @if($v['avatar_name'] == '')
                                            <img src="/item/user-default.png" class="avatar_name">
                                        @else
                                            @if (App\Helpers\Helper::isFB($v['avatar_name']) == true)
                                                <img src="{{ $v['avatar_name'] }}" class="avatar_name">
                                            @else
                                                <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/{{ $v['avatar_name'] }}" class="avatar_name">
                                                <!-- <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/{{ $v['avatar_name'] }}" class="avatar_name"> -->
                                            @endif
                                        @endif
                                        <span class="us-name">{{ $v['name'] }}</span>
                                    </a>
                                    @if (Auth::check())
                                        @if (App\Helpers\Helper::isUser($v['id']) == true)
                                            <i class="fas fa-align-right modal-open modal-pos acbtn del-open"></i>
                                            <div id="modal">
                                                <div class="iziModal-content">
                                                    <a data-izimodal-close="" class="modal-close">×</a>
                                                    <!-- modal -->
                                                    <div class="select-modal">
                                                        <!-- delete -->
                                                        <button type="button" class="acbtn deletebtn-modal" id="content_delete">
                                                            {!! Form::open(['url' => '/content/'.$content['id'], 'method' => 'delete', 'onSubmit' => 'return check()']) !!}

                                                                {!! Form::hidden('id',$content['id']) !!}
                                                                {!! Form::submit('この投稿を削除する',['class' => 'btn-sub', 'name' => 'btn']) !!}

                                                            {!! Form::close() !!}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- <a href="javascript:history.back()" class="history-back"><i class="fas fa-undo fa-2x"></i></a> -->
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="content-group clearfix">
                                    <!-- slide show-->
                                    <div class="form-group slick-slider">
                                        <?php foreach($img as $v):?>
                                                <?php if(App\Helpers\Helper::judgeImgorVideo($v) == 0): ?>
                                                    <div>
                                                        <img class="slide_item_img" src="{{ $v }}">
                                                    </div>
                                                <?php elseif(App\Helpers\Helper::judgeImgorVideo($v) == 1): ?>
                                                    <div class="slide-backgraound">
                                                        <video class="slide_item_video" src="{{ $v }}" controls></video>
                                                    </div>
                                                <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if(App\Helpers\Helper::isMobile() == false): ?>
                                        @if (Auth::check())

                                                <button class="likes-btn fav-btn" type="submit" id="like_delete" style="@if (!$like) display: none; @endif" value="{{$content['id']}}">
                                                    <input type="hidden" value="{{ Auth::user()->id }}" id="user_info">
                                                  <input type="hidden" value="@if ($like){{ $like->id }}@endif" id="like_info">
                                                  <img src="/item/like.png">
                                                  <span id="likes" class="likes_count">{{ $content['likes_count'] }}</span>
                                                </button>

                                                <button class="likes-btn fav-btn" type="submit" id="like_store" value="{{$content['id']}}" style="@if ($like) display: none; @endif">
                                                    <input type="hidden" value="{{ Auth::user()->id }}" id="user_info">
                                                    <input type="hidden" value="{{ $content['user_id'] }}" id="content_user_id">
                                                  <img src="/item/dislike.png">
                                                  <span id="likes0" class="likes_count">{{ $content['likes_count'] }}</span>
                                                </button>
                                        @else
                                            <span class="modal-open modal-pos acbtn">
                                                <button class="likes-btn fav-btn" id="" value="">
                                                    <input type="hidden" value="" id="">
                                                    <img src="/item/like.png">
                                                    <span id="likes" class="likes_count">{{ $content['likes_count'] }}</span>
                                                </button>
                                            </span>

                                            <div id="modal">
                                                <div class="iziModal-content">
                                                    <a data-izimodal-close="" class="modal-close">×</a>
                                                    <!-- modal -->
                                                    <div class="select-modal">
                                                        <a href="/login">you need login</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    <?php endif; ?>

                                    <?php if(App\Helpers\Helper::isMobile() == true): ?>
                                        @if (Auth::check())

                                                <button class="likes-btn" type="submit" id="like_delete" style="@if (!$like) display: none; @endif" value="{{$content['id']}}">
                                                    <input type="hidden" value="{{ Auth::user()->id }}" id="user_info">
                                                  <input type="hidden" value="@if ($like){{ $like->id }}@endif" id="like_info">
                                                  <img src="/item/like.png">
                                                  <p id="likes" class="likes_count">{{ $content['likes_count'] }}</p>
                                                </button>

                                                <button class="likes-btn" type="submit" id="like_store" value="{{$content['id']}}" style="@if ($like) display: none; @endif">
                                                    <input type="hidden" value="{{ Auth::user()->id }}" id="user_info">
                                                    <input type="hidden" value="{{ $content['user_id'] }}" id="content_user_id">
                                                  <img src="/item/dislike.png">
                                                  <p id="likes0" class="likes_count">{{ $content['likes_count'] }}</p>
                                                </button>
                                        @else
                                            <span class="modal-open modal-pos acbtn">
                                                <button class="likes-btn" id="" value="">
                                                    <input type="hidden" value="" id="">
                                                    <img src="/item/like.png">
                                                    <p id="likes" class="likes_count">{{ $content['likes_count'] }}</p>
                                                </button>
                                            </span>

                                            <div id="modal">
                                                <div class="iziModal-content">
                                                    <a data-izimodal-close="" class="modal-close">×</a>
                                                    <!-- modal -->
                                                    <div class="select-modal">
                                                        <a href="/login">you need login</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    <?php endif;  ?>
                                    @if (Auth::check())
                                        <div class="content-blocker">
                                            <h2 class="spot_name">{{ $content['spot_name'] }}</h2>
                                            <input type="hidden" id="lat_detail" value="{{ $content['lat'] }}">
                                            <input type="hidden" id="lng_detail" value="{{ $content['lng'] }}">
                                            <p id="address_detail" class="address_detail">{{ $content['address'] }}</p>
                                                <a href="http://maps.google.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16" target="_blank">
                                                    <div id="js-access-map" class="map-direction acbtn">
                                                        <p class="direction-map">Directions</p>
                                                        <i class="fas fa-map-marker-alt fa-2x"></i></div>
                                                </a>

                                            <div class="comment-section">
                                                <div class="comment-h3 clearfix">
                                                    <i class="far fa-comment fa-3x comment-fas"></i>
                                                    <h3 class="comment-title">Comment</h3>
                                                </div>
                                                <p>
                                                    <?php echo App\Helpers\Helper::commentTotag($content['comment']); ?>
                                                </p>
                                            </div>

                                        </div>
                                    @else
                                        <div class="content-blocker">
                                            <h2 class="spot_name">{{ $content['spot_name'] }}</h2>
                                            <input type="hidden" id="lat_detail" value="{{ $content['lat'] }}">
                                            <input type="hidden" id="lng_detail" value="{{ $content['lng'] }}">
                                            <p id="address_detail" class="address_detail">{{ $content['address'] }}</p>
                                                <a href="http://maps.google.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16" target="_blank">
                                                    <div id="js-access-map" class="map-direction acbtn">
                                                        <p class="direction-map">Directions</p>
                                                        <i class="fas fa-map-marker-alt fa-2x"></i></div>
                                                </a>

                                            <div class="comment-section">
                                                <div class="comment-h3 clearfix">
                                                    <i class="far fa-comment fa-3x comment-fas"></i>
                                                    <h3 class="comment-title">Comment</h3>
                                                </div>
                                                <p>
                                                    <?php echo App\Helpers\Helper::commentTotag($content['comment']); ?>
                                                </p>
                                            </div>

                                        </div>
                                    @endif

                                    <div id="map_canvas" class="map_canvas"></div>
                                    <div id="getcurrentlocation" class="get-current">
                                        <p class="current-p acbtn">現在地を取得する</p>
                                    </div>

                                    <div class="sns-section">
                                        <div class="sharethis-inline-share-buttons"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 side-bar">
                            <ul class="form-group clearfix around-section content_list">
                                <?php if($around != ''): ?>
                                <h3 class="user-list-h3">このスポット周辺の投稿</h3>
                                    <?php App\Helpers\Helper::sideContentList($around); ?>
                                <?php endif; ?>
                            </ul>
                            <h3 class="user-list-h3">人気のユーザー</h3>
                            <div class="clearfix content-top">
                                <?php App\Helpers\Helper::SideUserList($users); ?>
                            </div>
                            <h3 class="user-list-h3">人気のタグ</h3>
                            <div class="clearfix content-top">
                                <?php $recommendtags = App\Helpers\Helper::recommendTags(); ?>
                            <ul>
                                <?php foreach($recommendtags as $tag): ?>
                                    <li class="tag">
                                        <a href="/search?q=<?php echo $tag; ?>">
                                            <?php echo $tag; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
</div>
<script>

function check(){

if(window.confirm('この投稿を削除しますか？')){
        return true;
    }
    else{
        window.alert('キャンセルされました');
        return false;
    }
}

</script>
@endsection

@section('js')
<script src="{{asset('js/iziModal.min.js')}}"></script>
<script src="{{asset('js/content.js')}}"></script>
<script src="{{asset('js/_like.js')}}"></script>
<!-- <script src="{{asset('js/more.js')}}"></script> -->

@endsection
