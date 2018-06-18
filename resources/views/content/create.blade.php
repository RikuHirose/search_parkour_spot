@extends('layouts.app')

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

<!-- contentの読み込み -->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    {!! Form::open(['url' => '/content/store', 'method' => 'post', 'files' => true, 'name' => 'post']) !!}
                    {{ csrf_field() }}

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

                        <!-- <label for="file" class="control-label">upload img</label>
                        <input name="file" type="file" id="file"> -->
                        <br>
                        <label for="photo">画像ファイル（複数可）:</label>
                        <input type="file" class="form-control" name="files[][photo]">
                        <input type="file" class="form-control" name="files[][photo]">
                        <input type="file" class="form-control" name="files[][photo]">
                        <input type="file" class="form-control" name="files[][photo]">
                    </div>
                    <div class="form-group">
                        <span class="star-rating">
                          <input type="radio" name="rating" value="1"><i></i>
                          <input type="radio" name="rating" value="2"><i></i>
                          <input type="radio" name="rating" value="3"><i></i>
                          <input type="radio" name="rating" value="4"><i></i>
                          <input type="radio" name="rating" value="5"><i></i>
                        </span>
                    </div>
                    <body onload="create()"></body>
                    <div class="form-group">
                        <table style="width:500px;border:0;" >
                            <tr>
                                <td width="50px">緯度</td>
                                <td id="lat">{{ Input::old('lat') }}</td>
                            </tr>
                            <tr>
                                <td>経度</td>
                                <td id="lng">{{ Input::old('lng') }}</td>
                            </tr>
                            <tr>
                                <td>住所</td>
                                <td id="address">{{ Input::old('address') }}</td>
                            </tr>
                        </table>
                        <!-- jsで取得した値をvalueに格納して送信する -->
                        <input type="hidden" name="file" value="{{ Input::old('file') }}" type="file" id="old_file">
                        <input type="hidden" name="lat" value="{{ Input::old('lat') }}" id="old_lat">
                        <input type="hidden" name="lng" value="{{ Input::old('lng') }}" id="old_lng">
                        <input type="hidden" name="address" value="{{ Input::old('address') }}" id="old_address">


                        <div id="map_canvas" style="width:480px; height:300px"></div>
                    </div>

                    <input type="text" name="spot_name" value="{{ Input::old('spot_name') }}" placeholder="spot_name">
                    <div class="form-group">
                        {!! Form::submit('upload', ['class' => 'btn btn-default']) !!}
                    </div>
                    {!! Form::close() !!}

                    <div class="form-group">
                        <button id="getcurrentlocation"> get current location</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection