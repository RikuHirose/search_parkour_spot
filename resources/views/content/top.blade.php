@extends('layouts.app')

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="top-display">
    <!--↓↓ 検索フォーム ↓↓-->
    <form class="top-form" action="/search" method="get">
      <div class="">
      <input type="text" name="tag" class="top-form-input" placeholder="気になるTagから検索する">
      <input type="submit" value="検索" class="btn btn-info">
      </div>
    </form>
    <form class="top-form" action="/place" method="get">
      <div class="">
      <!-- <input type="text" name="tag" class="top-form-input" placeholder="気になる地名から検索する"> -->
      <input id="pac-input" class="top-form-input" type="text"  name="place" placeholder="気になる地名から検索する">
      <input type="submit" value="検索" class="btn btn-info">
      </div>
    </form>

</div>

<div class="wrap">
    <div class="card">
        <div class="card-body">

            <h2 class="content-header">#ranking</h2>
            <div class="content-group clearfix">
                <?php App\Helpers\Helper::RankingContentList($ranking); ?>
            </div>
            <h2 class="content-header">#new</h2>
            <div class=" clearfix">
                <?php App\Helpers\Helper::TopOneColumnContentList($content); ?>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
  initAutocomplete();


  function initAutocomplete() {
    var input = document.getElementById('pac-input');
    if (!input) { return }


    // Create the search box and link it to the UI element.
    var searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    // map.addListener('bounds_changed', function() {
    //   searchBox.setBounds(map.getBounds());
    // });

    // var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      // // Clear out the old markers.
      // markers.forEach(function(marker) {
      //   marker.setMap(null);
      // });
      // markers = [];

      // For each place, get the icon, name and location.
      // var bounds = new google.maps.LatLngBounds();
      // places.forEach(function(place) {
      //   if (!place.geometry) {
      //     console.log("Returned place contains no geometry");
      //     return;
      //   }

      //   var icon = {
      //     url: place.icon,
      //     size: new google.maps.Size(71, 71),
      //     origin: new google.maps.Point(0, 0),
      //     anchor: new google.maps.Point(17, 34),
      //     scaledSize: new google.maps.Size(25, 25)
      //   };

      //   // Create a marker for each place.
      //   markers.push(new google.maps.Marker({
      //     map: map,
      //     icon: icon,
      //     title: place.name,
      //     position: place.geometry.location
      //   }));

      //   if (place.geometry.viewport) {
      //     // Only geocodes have viewport.
      //     bounds.union(place.geometry.viewport);
      //   } else {
      //     bounds.extend(place.geometry.location);
      //   }
      // });
      // map.fitBounds(bounds);
    });
  }
</script>
@endsection
