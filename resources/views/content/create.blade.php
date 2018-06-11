@extends('layouts.app')

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

                        <label for="file" class="control-label">upload img</label>
                        <input name="file" type="file" id="file">
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

                    <!-- <label for="comment">comment</label><br>
                    <textarea id="comment" name="comment"  placeholder="comment">{{ Input::old('comment') }}</textarea> -->
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
