@extends('layouts.app')

@section('content')
<div class="container">
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
                        @if($content['icon_name'])
                            <div>
                                <p>
                                    <img src="{{ asset('storage/avatar/' . $content['icon_name']) }}" alt="avatar" style="object-fit: cover;height: 150px;width: 150px;">

                                </p>
                                <p>spot_name::{{ $content->spot_name }}</p>
                            </div>
                        @endif
                    </div>
                    <body onload="editmap('{{ $content->lat }}', '{{ $content->lng }}')"></body>
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

                        {!! Form::label('file', 'upload img', ['class' => 'control-label']) !!}
                        {!! Form::file('file') !!}

                        <input type="text" name="spot_name" value="{{ Input::old('spot_name') }}" placeholder="{{ $content->spot_name }}">
                        <input type="hidden" id="lat_detail" value="{{ $content->lat }}">
                        <input type="hidden" id="lng_detail" value="{{ $content->lng }}">

                        <input type="hidden" name="lat" value="{{ Input::old('lat') }}" id="old_lat">
                        <input type="hidden" name="lng" value="{{ Input::old('lng') }}" id="old_lng">
                        <input type="hidden" name="address" value="{{ Input::old('address') }}" id="old_address">
                        <div class="form-group">
                            {!! Form::submit('edit', ['class' => 'btn btn-default']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <!-- search -->
                    <input type="text" size="55" id="search"  placeholder="search park" />
                    <input type="button" size="55" value="検索" onClick="SearchGo()" />
                    <!-- map -->
                    <div id="map_canvas" style="width:480px; height:300px"></div>
                    <!-- get current location -->
                    <div class="form-group">
                        <button id="getcurrentlocation"> get current location</button>
                    </div>
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
