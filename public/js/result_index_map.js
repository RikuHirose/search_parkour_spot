(function() {
  'use strict';


 var content_location = @json($content_location);

    var map;
    var marker;
    var infoWindow;
    var zoom;
    var lat;
    var lng;


    setDefault();

    //  defaultの場所を設定
    function setDefault() {
        lat = 35.729756;
        lng = 139.711069;
        zoom = 3;

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

})();