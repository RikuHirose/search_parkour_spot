(function() {
	'use strict';

	var Marker;
	var myLatLng;
	var map;
	var zoom;

	var lat = document.getElementById('lat_detail').value;
	var lng = document.getElementById('lng_detail').value;

	if(lat === "" || lat === null || lat === undefined && lng === "" || lng === null || lng === undefined){
	    lat = '';
	    lng = '';
	}else{
	    lat = lat;
	    lng = lng;
	}

	// 現在地取得
	// geoLocationInit();
	document.getElementById('getcurrentlocation').onclick = function() {
    	geoLocationInit();
  	}

	function geoLocationInit() {
	    if (navigator.geolocation) {
	        navigator.geolocation.getCurrentPosition(success, fail);

	    } else {
	        alert('fail');
	    }
	}

	 // success
	function success(position) {
	    var currentLat = position.coords.latitude;
	    var currentLng = position.coords.longitude;

	    // document.getElementById('currentLat').value = currentLat;
	    // document.getElementById('currentLng').value = currentLng;

	    // show action でcurrentpositonを取りたい
	    // var _token = $('meta[name="csrf-token"]').attr('content');
    	// $.post('http://127.0.0.1:8000/api/getCurrent',{lat:currentLat,lng:currentLng,_token:_token},function(match){});
  //   	zoom = 13;
  //   	myLatLng = new google.maps.LatLng(lat, lng);
		// createContentMap(myLatLng,zoom);

	    CurrentPositionMarker(currentLat, currentLng);
	}

	// fail
	function fail() {
	   	zoom = 2;
    	myLatLng = new google.maps.LatLng(lat, lng);
		createContentMap(myLatLng,zoom);
	}


		zoom = 12;
    	myLatLng = new google.maps.LatLng(lat, lng);
		createContentMap(myLatLng,zoom);

	//Create Map
    function createContentMap(myLatLng,zoom) {
        map = new google.maps.Map(document.getElementById('map_canvas'), {
            center: myLatLng,
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map
        });
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

})();