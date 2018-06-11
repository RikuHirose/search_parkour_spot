function editmap(lat,lng) {
  var lat = lat;
  var lng = lng;
  var Marker;
  var map;

  // 最初に設定したlat lngのマーカーを作成
  var old_lat = document.getElementById('old_lat').value;
  var old_lng = document.getElementById('old_lng').value;

  if(old_lat === '' ||  old_lat === null && old_lng === '' ||  old_lng === null){
    setDefault(lat,lng);
  }else{
    createMap(old_lat,old_lng);
  }



  //  defaultの場所を設定
  function setDefault() {
    lat = lat;
    lng = lng;
    createMap(lat,lng);
  }

  // 現在地取得
  document.getElementById('getcurrentlocation').onclick = function() {
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

      createMap(latval,lngval);
      CurrentPositionMarker(latval,lngval);
  }

  // fail
  function fail() {
    setDefault();
  }

  // create Map
  function createMap(latval,lngval) {
    var latlng = new google.maps.LatLng(latval,lngval);
    var opts = {
        zoom: 14,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    //id属性に"map_canvas"を指定しdiv要素を対象とするMapsクラスのオブジェクトを作成
    map = new google.maps.Map(document.getElementById("map_canvas"),opts);
    var default_marker = new google.maps.Marker({
        position: latlng,
        map: map
    });
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
      document.getElementById('id_level').innerHTML = level;

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


};