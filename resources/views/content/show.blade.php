@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/slick/slick-theme.css') }}"/>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

                    <?php var_dump($img); ?>
                    <!-- slide show-->
                    <div class="form-group slick-slider">
                            <?php foreach($img as $v): ?>
                                <div>
                                    <img class="card_item_img" src="/item/{{ $v }}">
                                </div>
                            <?php endforeach; ?>
                    </div>

                    <div>
                        <p id="lat_detail">{{ $content['lat'] }}</p>
                        <p id="lng_detail">{{ $content['lng'] }}</p>
                        <p id="lng_detail">{{ $content['address'] }}</p>
                        <p>spot_name: {{ $content['spot_name'] }}</p>
                        <p>{{ $content['rating'] }}</p>
                        <span class="star-rating">
                            <?php for($i = 1; $i <= $content['rating']; $i++): ?>
                                <i class="star"></i>
                            <?php endfor; ?>
                        </span>
                    </div>

                    <body onload="content()"></body>
                    <div id="map_canvas" style="width:480px; height:300px"></div>

                    <!-- spot lat lng -->
                    <body onload="getroute('{{ $content['lat'] }}', '{{ $content['lng'] }}')"></body>
                    <input type="hidden" value="" id="currentLat">
                    <input type="hidden" value="" id="currentLng">

                    <p id="js-access-map"><a href="http://maps.google.com/maps?saddr=&daddr={{ $content['lat'] }},{{ $content['lng'] }}&z=16"><i class="fa fa-map-marker fa-fw"></i>地図アプリで道順を見る</a></p>
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
                        <?php ContentList($around); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

function ContentList($content)
{
    $content = array_reverse($content);
    foreach($content as $v):
    ?>
        <a href="/content/<?php echo $v['id']; ?>">
            <div class="card_item">
                <?php
                    $i = 0;
                    $num = 1;
                    foreach ($v['img'] as $img) {
                        if($i >= $num){
                            break;
                        }else{
                            echo "<img class='card_item_img' src='/item/$img'>";
                                $i++;
                            }
                        }
                ?>
                <div class="card_item_detail">
                    <p class="card_item_name">spot_name: {{ $v['spot_name'] }}</p>
                    <p class="rating-number">{{ $v['rating'] }}</p>
                    <span class="star-rating">
                        <?php for($i = 1; $i <= $v['rating']; $i++): ?>
                            <i class="star"></i>
                        <?php endfor; ?>
                    </span>
                </div>
            </div>
        </a>
    <?php endforeach;
} ?>
@endsection
