function content() {
	var Marker;

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
	    var currentLat = position.coords.latitude;
	    var currentLng = position.coords.longitude;
	    document.getElementById('currentLat').value = currentLat;
	    document.getElementById('currentLng').value = currentLng;

	    // show action でcurrentpositonを取りたい
	    // var _token = $('meta[name="csrf-token"]').attr('content');
    	// $.post('http://127.0.0.1:8000/api/getCurrent',{lat:currentLat,lng:currentLng,_token:_token},function(match){});

	    CurrentPositionMarker(currentLat, currentLng);
	}

	// fail
	function fail() {
	   alert('fail');
	}


	var lat = document.getElementById('lat_detail');
	var lng = document.getElementById('lng_detail');

	if(lat === "" || lat === null || lat === undefined && lng === "" || lng === null || lng === undefined){
	    lat = '';
	    lng = '';
	}else{
	    lat = lat.textContent;
	    lng = lng.textContent;
	}


	myLatLng = new google.maps.LatLng(lat, lng);
	createContentMap(myLatLng);


	//Create Map
    function createContentMap(myLatLng) {
        map = new google.maps.Map(document.getElementById('map_canvas'), {
            center: myLatLng,
            zoom: 15,
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

};