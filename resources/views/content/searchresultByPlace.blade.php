@extends('layouts.app')

@section('title')
    「  {{$query}}  」の検索結果 {{ count($content) }}件   |
@endsection

<!-- cssの読み込み -->
@section('css')
<!-- <link href="{{ asset('css/top.css') }}" rel="stylesheet"> -->
<link href="{{ asset('css/show.css') }}" rel="stylesheet">
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="">
    <p class="search-result-word">「  {{$query}}  」の検索結果 {{ count($content) }}件</p>
    <!--↓↓ 検索フォーム ↓↓-->
    <!-- <form class="" action="/search" method="get">
      <div class="form-position">
        <input type="text" name="tag" class="top-form-input" placeholder="気になるTagから検索する" value="">
        <input type="submit" value="検索" class="btn btn-info">
      </div>
    </form> -->

   <!--  <form class="" action="/place" method="get">
      <div class="form-position">
        <input id="pac-input" class="top-form-input" type="text"  name="place" placeholder="気になる地名から検索する" value="">
        <input id="lat-input" type="hidden" name="lat" value="">
        <input id="lng-input" type="hidden" name="lng" value="">
        <input type="submit" value="検索" class="btn btn-info">
      </div>
    </form> -->

</div>

<div class="wrap">
    <div class="card">
        <?php if(App\Helpers\Helper::isMobile() == true): ?>
            <div class="card-header result-icons">
                <a id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
                <a id="result-map"><i class="fa fa-map-marker-alt fa-3x"></i></a>
            </div>

            <div class="card-body">
                <div class="container" id="content-block">
                    <div class="row content-position">
                        <div class="col-md-9">
                            <div class="content-group clearfix">
                                <ul class="form-group clearfix content_list">
                                    <?php App\Helpers\Helper::mobileSearchPlaceContentList($content,$query); ?>
                                    <?php App\Helpers\Helper::ResultMore($content); ?>
                                </ul>
                            </div>
                        </div>
                      <div class="col-md-3 side-bar">
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
            <div id="map-block">
                <div class="container" id="content-block">
                    <div class="row content-position">
                        <div class="col-md-9">
                            <div class="content-group clearfix">
                                <div id="map_canvas" class="map_canvas"></div>
                                <div id="getcurrentlocation" class="get-current">
                                    <p class="current-p">現在地を取得する</p>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-3 side-bar">
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
        <?php endif; ?>
        <!-- pc -->
        <?php if(App\Helpers\Helper::isMobile() == false): ?>
                <div class="row content-position">
                    <div class="col-md-8">

                        <div class="card-body">
                            <div class="card-header result-icons">
                                <a id="result-index" class="switch-left"><i class="fa fa-list-ul fa-3x"></i></a>
                                <a id="result-map"><i class="fa fa-map-marker-alt fa-3x"></i></a>
                            </div>
                            <div class="container" id="content-block">
                                <div class="content-group clearfix">
                                    <ul class="form-group clearfix content_list">
                                        <?php App\Helpers\Helper::SearchPlaceContentList($content,$query); ?>
                                        <!-- <?php App\Helpers\Helper::ResultMore($content); ?> -->
                                    </ul>
                                </div>
                            </div>
                            <div id="map-block">
                                <div class="content-group clearfix">
                                    <div id="map_canvas" class="map_canvas"></div>
                                    <div id="getcurrentlocation" class="get-current">
                                        <p class="current-p acbtn">現在地を取得する</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 side-bar">
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
        <?php endif; ?>
        
</div>

@endsection

@section('js')
<script src="{{asset('js/searchBox.js')}}"></script>
<script src="{{asset('js/result_switch.js')}}"></script>
<script src="{{asset('js/more.js')}}"></script>
<script type="text/javascript">
    // initAutocomplete();

    // function initAutocomplete() {
    //     var input = document.getElementById('pac-input');
    //     if (!input) { return }

    //     var searchBox = new google.maps.places.SearchBox(input);

    //     searchBox.addListener('places_changed', function() {
    //           var places = searchBox.getPlaces();
    //           if (places.length == 0) {
    //             return;
    //           }
    //           // console.log(places[0].geometry.location.lat(), places[0].geometry.location.lng())
    //           $('#lat-input').val(places[0].geometry.location.lat())
    //           $('#lng-input').val(places[0].geometry.location.lng())
    //         });
    // }
    initAutocomplete();

      function initAutocomplete() {
        var input = document.getElementById('pac-input');
        if (!input) { return }


        // Create the search box and link it to the UI element.
        var searchBox = new google.maps.places.SearchBox(input);

        $('#form_id').on('submit', function(e) {
          const form = this
          e.preventDefault()
          setTimeout(() => {
            form.submit()
          }, 300)
          return false
        });


        searchBox.addListener('places_changed', function() {
            // console.log('places_changed!!')
            var places = searchBox.getPlaces();
            if (places.length == 0) {
              return;
            }
            // console.log(places[0].geometry.location.lat(), places[0].geometry.location.lng())
            $('#lat-input').val(places[0].geometry.location.lat())
            $('#lng-input').val(places[0].geometry.location.lng())

        });
      }



    var content_location = @json($content_location);
    var search_location = @json($searchLocation);

    var map;
    var marker;
    var infoWindow;
    var zoom;
    var lat;
    var lng;

    var searchlat = search_location.lat;
    var searchlng = search_location.lng;


    setDefault(searchlat, searchlng);

    //  defaultの場所を設定
    function setDefault(searchlat,searchlng) {
        lat = searchlat;
        lng = searchlng;
        zoom = 12;

        createMap(lat,lng,zoom);
        SearchResultMap(content_location);
    }

    // 現在地取得
    // sgeoLocationInit();
    document.getElementById('getcurrentlocation').onclick = function() {
     geoLocationInit();
    }

    function geoLocationInit() {
        if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(success, fail);

        } else {
            alert('現在地を取得できませんでした');
            setDefault();
        }
    }

    // success
    function success(position) {
          var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        zoom = 13;

        createMap(lat,lng,zoom);
        CurrentPositionMarker(lat,lng);
        SearchResultMap(content_location);
    }

    // fail
    function fail() {
        setDefault();
    }

    // create Map
    function createMap(latval,lngval,zoom) {
        var latlng = new google.maps.LatLng(latval,lngval);
        var opts = {
            zoom: zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        //id属性に"map_canvas"を指定しdiv要素を対象とするMapsクラスのオブジェクトを作成
        map = new google.maps.Map(document.getElementById("map_canvas"),opts);
    }

    // 現在地のアイコンを表示
    function CurrentPositionMarker(lat,lng) {
        var latlng = new google.maps.LatLng(lat,lng);
        var image = 'http://i.stack.imgur.com/orZ4x.png';
        var size = new google.maps.Size(25, 25);
        var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                icon: {
                url :image,
                scaledSize: size,
                },
            });
        marker.setMap(map);
    }

    //Create marker
    function createMarker(latlng,name,id) {
         var marker = new google.maps.Marker({
            position: latlng,
            map: map,
        });
        createInfo(marker,name,id);
    }

    // 吹き出し
    function createInfo(marker,name,id) {
        // 画像表示/content/idへのリンク
        var infoWindow = new google.maps.InfoWindow({
          content: '\
          <div class="sample" id="contentid"></div>'
        });

        //吹き出し click
        marker.addListener('click', function() {
        infoWindow.open(map, marker);

        // redirect to /content/id
          var url = '/content/';
              location.href = url + id;
        });
    }


    function SearchResultMap(content_location) {

      $.each(content_location,function(i,val){
            var glat = val.lat;
            var glng = val.lng;
            var icon_name = val.icon_name;
            var id = val.id;
            var GLatLng = new google.maps.LatLng(glat, glng);

            createMarker(GLatLng,icon_name,id);
      });
  }
</script>
@endsection
