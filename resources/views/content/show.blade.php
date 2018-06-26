@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}"/>
<link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')


            <div class="card">
                <div class="card-header">Dashboard</div>

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
                        <p id="lat_detail">{{ $content['lat'] }}</p>
                        <p id="lng_detail">{{ $content['lng'] }}</p>
                        <p id="lng_detail">{{ $content['address'] }}</p>
                        <p>spot_name: {{ $content['spot_name'] }}</p>
                        <p>comment: {{ $content['comment'] }}</p>

                    </div>

                    <div id="map_canvas" class="map_canvas"></div>

                    <!-- spot lat lng -->
                    <!-- <body onload="getroute('{{ $content['lat'] }}', '{{ $content['lng'] }}')"></body> -->
                    <input type="hidden" value="" id="currentLat">
                    <input type="hidden" value="" id="currentLng">

                    <p id="js-access-map">
                        <a href="http://maps.google.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16" target="_blank"><i class="fa fa-map-marker fa-fw"></i>地図アプリで道順を見る</a>
                    </p>
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
@endsection

@section('js')
<script src="{{asset('js/content.js')}}"></script>
@endsection
