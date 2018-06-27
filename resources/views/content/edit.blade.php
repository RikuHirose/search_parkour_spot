@extends('layouts.app')

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

@section('content')
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

                    <div class="form-group">
                        <div>
                            <!-- slide show にする -->
                            <p>
                                <img class="card_item_img" src="/item/{{ $img[0] }}">
                            </p>

                            <p id="lat_detail">{{ $content['lat'] }}</p>
                            <p id="lng_detail">{{ $content['lng'] }}</p>
                            <p id="lng_detail">{{ $content['address'] }}</p>
                            <p>spot_name: {{ $content['spot_name'] }}</p>

                        </div>
                    </div>
                    <body onload="editmap('{{ $content['lat'] }}', '{{ $content['lng'] }}')"></body>
                    <div class="form-group">
                        <table style="width:500px;border:0;" >
                            <tr>
                                <td width="50px">緯度</td>
                                <td id="lat"></td>
                            </tr>
                            <tr>
                                <td>経度</td>
                                <td id="lng"></td>
                            </tr>
                            <tr>
                                <td>住所</td>
                                <td id="address"></td>
                            </tr>
                            <tr>
                                <td>ズーム</td>
                                <td id="id_level"></td>
                            </tr>
                        </table>
                        {!! Form::open(['url' => '/content/'.$content['id'], 'method' => 'put', 'files' => true, 'name' => 'post']) !!}
                        {{ csrf_field() }}

                        <br>
                        <label for="photo">画像ファイル（複数可）:</label>
                        <input type="file" class="form-control" name="files[][photo]">
                        <input type="file" class="form-control" name="files[][photo]">
                        <input type="file" class="form-control" name="files[][photo]">
                        <input type="file" class="form-control" name="files[][photo]">

                        <input type="text" name="spot_name" value="{{ $content['spot_name'] }}">
                        <div class="form-group">
                            <span class="star-rating">
                              <input type="radio" name="rating" value="1"><i></i>
                              <input type="radio" name="rating" value="2"><i></i>
                              <input type="radio" name="rating" value="3"><i></i>
                              <input type="radio" name="rating" value="4"><i></i>
                              <input type="radio" name="rating" value="5"><i></i>
                            </span>
                        </div>
                        

                        <input type="hidden" name="lat" value="{{ Input::old('lat') }}" id="old_lat">
                        <input type="hidden" name="lng" value="{{ Input::old('lng') }}" id="old_lng">
                        <input type="hidden" name="address" value="{{ Input::old('address') }}" id="old_address">

                        <input type="hidden" name="lat" value="{{ $content['lat'] }}" id="">
                        <input type="hidden" name="lng" value="{{ $content['lng'] }}" id="">
                        <input type="hidden" name="address" value="{{ $content['address'] }}" id="">
                        <div class="form-group">
                            {!! Form::submit('edit', ['class' => 'btn btn-default']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <!-- search -->
                    <input type="text" size="55" id="search"  placeholder="search park" />
                    <input type="button" size="55" value="検索" onClick="SearchGo()" />
                    <!-- map -->
                    <div id="map_canvas" class="map_canvas"></div>
                    <!-- get current location -->
                    <div class="form-group">
                        <button id="getcurrentlocation"> get current location</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    var lat = document.getElementById('old_lat').value;
    var lng = document.getElementById('old_lng').value;
    var address = document.getElementById('old_address').value;
    document.getElementById('lat').innerHTML = lat;
    document.getElementById('lng').innerHTML = lng;
    document.getElementById('address').innerHTML = address;
</script>
@endsection

@section('js')
<script src="{{asset('js/edit.js')}}"></script>
@endsection