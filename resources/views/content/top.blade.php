@extends('layouts.app')


@section('css')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="top-display">
  <?php if(App\Helpers\Helper::isMobile() == false):?>
    <!--↓↓ 検索フォーム ↓↓-->
    <form class="top-form" action="/search" method="get">
      <div class="">
      <input type="text" name="tag" class="top-form-input" placeholder="気になるTagから検索する">
      <input type="submit" value="検索" class="btn btn-info">
      </div>
    </form>

    <form class="top-form" action="/place" method="get" id="form_id">
      <div class="">
        <input id="pac-input" class="top-form-input" type="text"  name="place" placeholder="気になる地名から検索する">
        <input id="lat-input" type="hidden" name="lat" value="">
        <input id="lng-input" type="hidden" name="lng" value="">
        <input value="検索" class="btn btn-info" type="submit" id="btn_id">
      </div>
    </form>
  <?php endif; ?>

</div>

<div class="wrap">
    <div class="card">
        <div class="card-body">

            <h2 class="content-header">ranking</h2>
            <div class="content-group clearfix">
                <?php App\Helpers\Helper::RankingContentList($ranking); ?>
            </div>
            <h2 class="content-header">new</h2>
            <div class="clearfix content-top">
                <?php App\Helpers\Helper::TopOneColumnContentList($content); ?>
            </div>

            <h2 class="content-header">人気のユーザー</h2>
            <div class="clearfix content-top">
                
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
</script>
@endsection
