function route() {
  var Marker;
  var map;


  // 現在地取得
  geoLocationInit();

  function geoLocationInit() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(success, fail);

      } else {
          alert('fail');
      }
  }

  // success
  function success(position) {
      var startLat = position.coords.latitude;
      var startLng = position.coords.longitude;

      var targetLat = document.getElementById('lat').value;
      var targetLng = document.getElementById('lng').value;


      getRoute(startLat,startLng,targetLat,targetLng);
      CurrentPositionMarker(startLat,startLng);
  }

  // fail
  function fail() {
    alert('fail');
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

    var image = 'http://i.stack.imgur.com/KOh5X.png';
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        icon: image
    });
    marker.setMap(map);
  }


  var goalMarkerImg = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
  // var map = void 0;

  function getRoute(startLat,startLng,targetLat,targetLng) {
    var startLatLng = [startLat,startLng];
    var targetLatLng = [targetLat, targetLng];

    var options = {
      zoom: 10,
      center: new google.maps.LatLng(startLatLng[0], startLatLng[1]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map_canvas'), options);
    var rendererOptions = {
      map: map, // 描画先の地図
      draggable: true, // ドラッグ可
      preserveViewport: true // centerの座標、ズームレベルで表示
    };
    var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
    var directionsService = new google.maps.DirectionsService();
    directionsDisplay.setMap(map);
    var request = {
      origin: new google.maps.LatLng(startLatLng[0], startLatLng[1]), // スタート地点
      destination: new google.maps.LatLng(targetLatLng[0], targetLatLng[1]), // ゴール地点
      travelMode: google.maps.DirectionsTravelMode.WALKING // 移動手段
    };
    directionsService.route(request, function (response, status) {
      if (status === google.maps.DirectionsStatus.OK) {
        new google.maps.DirectionsRenderer({
          map: map,
          directions: response,
          suppressMarkers: true // デフォルトのマーカーを削除
        });
        var leg = response.routes[0].legs[0];
        makeMarker(leg.end_location, markers.goalMarker, map);
        setTimeout(function () {
          map.setZoom(11); // ルート表示後にズーム率を変更
        });
      }
    });
  }

  function makeMarker(position, icon, map) {
    var marker = new google.maps.Marker({
      position: position,
      map: map,
      icon: icon
    });
  }

  var markers = {
    goalMarker: new google.maps.MarkerImage(goalMarkerImg, // 画像のパス
    new google.maps.Size(24, 33), // マーカーのwidth,height
    new google.maps.Point(0, 0), // 画像データの中で、どの部分を起点として表示させるか
    new google.maps.Point(12, 33), // マーカーのpositionで与えられる緯度経度を画像のどの点にするか
    new google.maps.Size(24, 33)) // 画像の大きさを拡大縮小
  };



};