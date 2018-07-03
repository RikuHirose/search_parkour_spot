@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}"/>
<link href="{{ asset('css/show.css') }}" rel="stylesheet">
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')


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
                                    <img src="/item/user/{{ $v['avatar_name'] }}" class="avatar_name">
                                @endif
                            @endif
                            {{ $v['name'] }}
                        </a>
                        @if (Auth::check())
                            @if (App\Helpers\Helper::isUser($v['id']) == true)
                                <!-- delete -->
                                <button type="button" class="btn btn-default" id="content_delete">
                                    {!! Form::open(['url' => '/content/'.$content['id'], 'method' => 'delete', 'onSubmit' => 'return check()']) !!}

                                        {!! Form::hidden('id',$content['id']) !!}
                                        {!! Form::submit('delete',['class' => 'btn btn-default', 'name' => 'btn']) !!}

                                    {!! Form::close() !!}
                                </button>
                            @else
                                <p>not you</p>
                            @endif
                        @endif
                    @endforeach
                </div>
                <div class="card-body">
                    <!-- success message -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- error message -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- slide show-->
                    <div class="form-group slick-slider">
                        <?php foreach($img as $v):?>
                                <?php if(App\Helpers\Helper::judgeImgorVideo($v) == 0): ?>
                                    <div>
                                        <img class="slide_item_img" src="/item/{{ $v }}">
                                    </div>
                                <?php elseif(App\Helpers\Helper::judgeImgorVideo($v) == 1): ?>
                                    <div class="slide-backgraound">
                                        <video class="slide_item_video" src="/item/{{ $v }}" controls></video>
                                    </div>
                                <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div>
                        <p class="spot_name">{{ $content['spot_name'] }}</p>
                        <input type="hidden" id="lat_detail" value="{{ $content['lat'] }}">
                        <input type="hidden" id="lng_detail" value="{{ $content['lng'] }}">
                        <p id="address_detail">{{ $content['address'] }}</p>
                        <p id="js-access-map" class="map-direction">
                            <a href="http://maps.google.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16" target="_blank">Direction<img src="/item/place-icon.png" class=""></a>
                        </p>

                        <p>{{ $content['comment'] }}</p>

                    </div>


                    @if (Auth::check())

                        <button type="submit" id="like_delete" style="@if (!$like) display: none; @endif" value="{{$content['id']}}">
                            <input type="hidden" value="{{ Auth::user()->id }}" id="user_info">
                          <input type="hidden" value="@if ($like){{ $like->id }}@endif" id="like_info">
                          <img src="/item/like.png">
                          <p id="likes">{{ $content['likes_count'] }}</p>
                        </button>

                        <button type="submit" id="like_store" value="{{$content['id']}}" style="@if ($like) display: none; @endif">
                            <input type="hidden" value="{{ Auth::user()->id }}" id="user_info">
                          <img src="/item/dislike.png">
                          <p id="likes0">{{ $content['likes_count'] }}</p>
                        </button>
                    @else
                    <a href="/login">
                        <button id="" value="">
                            <input type="hidden" value="" id="">
                            <img src="/item/like.png">
                            <p id="likes">{{ $content['likes_count'] }}</p>
                        </button>
                    </a>
                    @endif
                    <div id="map_canvas" class="map_canvas"></div>


                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                    <a class="twitter-share-button"
                          href="https://twitter.com/share"
                          data-size="large"
                          data-url="https://dev.twitter.com/web/tweet-button"
                          data-via="twitterdev"
                          data-related="twitterapi,twitter"
                          data-hashtags="example,demo"
                          data-text="custom share text"
                          data-size="large"
                          data-lang="ja"
                          data-dnt="true">
                        Tweet
                    </a>

                    <div class="form-group clearfix">
                        <h2>#このスポット周辺の投稿</h2>
                        <?php App\Helpers\Helper::OneColumnContentList($around); ?>
                    </div>
                </div>
            </div>
<script>

function check(){

if(window.confirm('削除しますか？')){
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
<script src="{{asset('js/content.js')}}"></script>
<script src="{{asset('js/_like.js')}}"></script>
@endsection
