@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}"/>
<link href="{{ asset('css/show.css') }}" rel="stylesheet">
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="wrap">
            <div class="card">
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
                                <i class="fas fa-align-right modal-open"></i>
                                <div id="modal">
                                    <div class="iziModal-content">
                                        <a data-izimodal-close="">×</a>
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
                                <a href="javascript:history.back()" class="history-back"><i class="fas fa-undo fa-2x"></i></a>
                            @endif
                        @endif
                    @endforeach
                </div>
                <div class="card-body">
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
                        <span class="modal-open">
                            <button class="likes-btn" id="" value="">
                                <input type="hidden" value="" id="">
                                <img src="/item/like.png">
                                <p id="likes" class="likes_count">{{ $content['likes_count'] }}</p>
                            </button>
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
                    @endif

                    <div>
                        <h2 class="spot_name">{{ $content['spot_name'] }}</h2>
                        <input type="hidden" id="lat_detail" value="{{ $content['lat'] }}">
                        <input type="hidden" id="lng_detail" value="{{ $content['lng'] }}">
                        <p id="address_detail" class="address_detail">{{ $content['address'] }}</p>
                            <a href="http://maps.google.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16" target="_blank">
                                <div id="js-access-map" class="map-direction">
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

                    <div id="map_canvas" class="map_canvas"></div>
                    <div id="getcurrentlocation" class="get-current">
                        <p class="current-p">現在地を取得する</p>
                    </div>

                    <div class="sns-section">
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>

                    <ul class="form-group clearfix around-section content_list">
                        <h2 class="content-header">このスポット周辺の投稿(<?php echo count($around); ?>件)</h2>
                        <?php if($around == ''): ?>
                            <p>周辺にスポットはありません</p>
                        <?php else: ?>
                            <?php App\Helpers\Helper::OneColumnContentList($around); ?>
                            <div id="more_btn">もっと見る <i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                            <div id="close_btn">表示数を戻す <i class="fa fa-chevron-up" aria-hidden="true"></i></div>
                        <?php endif; ?>
                    </ul>
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
<script src="{{asset('js/more.js')}}"></script>
@guest
        <script src="{{asset('js/iziModal.min.js')}}"></script>
@endguest
@endsection
