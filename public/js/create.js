(function() {
  'use strict';

  var Marker;
  var map;
  var zoom;
  var lat;
  var lng;

  // 最初に設定したlat lngのマーカーを作成
  var old_lat = document.getElementById('old_lat').value;
  var old_lng = document.getElementById('old_lng').value;
  zoom = 13;

  if(old_lat === '' ||  old_lat === null && old_lng === '' ||  old_lng === null){
    setDefault();
  }else{
    createMap(old_lat,old_lng,zoom);
  }

  setDefault();
  //  defaultの場所を設定
  function setDefault() {
    lat = 35.729756;
    lng = 139.711069;
    zoom = 3;
    createMap(lat,lng,zoom);
  }

  // 現在地取得
  document.getElementById('selectcurrentlocation').onclick = function() {
    geoLocationInit();
  }

  function geoLocationInit() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(success, fail);

      } else {
          setDefault();
      }
  }

  // success
  function success(position) {
    var latval = position.coords.latitude;
    var lngval = position.coords.longitude;
    zoom = 13;

    createMap(latval,lngval,zoom);
    CurrentPositionMarker(latval,lngval);


    var latlng = new google.maps.LatLng(latval,lngval);
    var opts = {
        zoom: zoom,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    //id属性に"map_canvas"を指定しdiv要素を対象とするMapsクラスのオブジェクトを作成
    map = new google.maps.Map(document.getElementById("map_canvas"),opts);

    var default_marker = new google.maps.Marker({
        position: latlng,
        map: map
    });

    infotable(latval,lngval,map.getZoom());
    geocode2(latval,lngval);

    mapEvent(map,default_marker,latval,lngval);
    CurrentPositionMarker(latval,lngval);

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
    // if (!map) {
    //   map = new google.maps.Map(document.getElementById("map_canvas"),opts);
    // }
    map = new google.maps.Map(document.getElementById("map_canvas"),opts);

    // 最初に設定したlat lngのマーカーを作成
    var old_lat = document.getElementById('old_lat').value;
    var old_lng = document.getElementById('old_lng').value;


    var latlng = new google.maps.LatLng(old_lat,old_lng);
    var default_marker = new google.maps.Marker({
        position: latlng,
        map: map
    });

    // 検索バー
    initAutocomplete(map);
    mapEvent(map,default_marker);
  }


  // 現在地のアイコンを表示
  function CurrentPositionMarker(lat,lng) {
    var latlng = new google.maps.LatLng(lat,lng);
    var image = 'http://i.stack.imgur.com/orZ4x.png';
    var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: image
        });
    marker.setMap(map);
  }

  function mapEvent(map,default_marker){
      //地図上でクリックするとマーカーを表示させ、マーカーは移動可能とするイベント登録
      google.maps.event.addListener(map, 'click',
          function(event) {
            // default_markerの削除
            default_marker.setMap(null);

            if (Marker){Marker.setMap(null)};
              Marker = new google.maps.Marker({
               position: event.latLng,
               draggable: true,
               map: map
            });
        infotable(Marker.getPosition().lat(),
        Marker.getPosition().lng(),map.getZoom());
        geocode();

        //マーカー移動後に座標を取得するイベントの登録
        google.maps.event.addListener(Marker,'dragend',
          function(event) {
            infotable(Marker.getPosition().lat(),
            Marker.getPosition().lng(),map.getZoom());
            geocode();
        })

        //ズーム変更後に倍率を取得するイベントの登録
        google.maps.event.addListener(map, 'zoom_changed',
          function(event) {
            infotable(Marker.getPosition().lat(),
            Marker.getPosition().lng(),map.getZoom());
        })
      })
  }

  //HTMLtagを更新
  function infotable(lat,lng,level){
      document.getElementById('lat').innerHTML = lat;
      document.getElementById('lng').innerHTML = lng;

      document.forms.post.elements.lat.value = lat;
      document.forms.post.elements.lng.value = lng;
  };

  //マーカーの位置を地図座標に変換するジオコーディングの設定
  function geocode(){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'location': Marker.getPosition()},
      function(results, status) {
       if (status == google.maps.GeocoderStatus.OK && results[0]){

        document.forms.post.elements.address.value = results[0].formatted_address.replace(/^日本, /, '');
        document.getElementById('address').innerHTML = results[0].formatted_address.replace(/^日本, /, '');

       }else{
         document.getElementById('address').innerHTML = "Geocode 取得に失敗しました";
        alert("Geocode 取得に失敗しました reason: "
               + status);
       }
      });
  }

  // マーカーの位置を地図座標に変換するジオコーディングの設定
  function geocode2(lat,lng){
    var latlng = new google.maps.LatLng(lat,lng);
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'location': latlng},
      function(results, status) {
       if (status == google.maps.GeocoderStatus.OK && results[0]){

        document.forms.post.elements.address.value = results[0].formatted_address.replace(/^日本, /, '');
        document.getElementById('address').innerHTML = results[0].formatted_address.replace(/^日本, /, '');

       }else{
         document.getElementById('address').innerHTML = "Geocode 取得に失敗しました";
        alert("Geocode 取得に失敗しました reason: "
               + status);
       }
      });
  }



  function initAutocomplete(map) {
    var input = document.getElementById('map-input');
    if (!input) { return }
    // var map = new google.maps.Map(document.getElementById('map_canvas'), {
    //   center: {lat: latval, lng: lngval},
    //   zoom: zoom,
    //   mapTypeId: 'roadmap'
    // });
    var map = map;

    // Create the search box and link it to the UI element.
    var searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      // Clear out the old markers.
      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];

      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }

        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };

        // // Create a marker for each place.
        // markers.push(new google.maps.Marker({
        //   map: map,
        //   icon: icon,
        //   title: place.name,
        //   position: place.geometry.location
        // }));

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      map.fitBounds(bounds);
    });
  }



})();
