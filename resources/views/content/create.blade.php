@extends('layouts.app')

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

<!-- contentの読み込み -->
@section('content')
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

                        <br>
                        <label for="photo">画像ファイル（複数可）:</label>
                        <input type="file" class="form-control" name="files[][photo]" multiple="multiple">
                    </div>
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
                        <!-- <input type="hidden" name="file" value="{{ Input::old('file') }}" type="file" id="old_file"> -->
                        <input type="hidden" name="lat" value="{{ Input::old('lat') }}" id="old_lat">
                        <input type="hidden" name="lng" value="{{ Input::old('lng') }}" id="old_lng">
                        <input type="hidden" name="address" value="{{ Input::old('address') }}" id="old_address">

                        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                        <div id="map_canvas" class="map_canvas"></div>
                    </div>

                    <input type="text" name="spot_name" value="{{ Input::old('spot_name') }}" placeholder="spot_name">
                    <textarea name="comment" rows="4" cols="40" placeholder="キャプションを書く" id="tag_caption">{{ Input::old('comment') }}</textarea>

                    <div class="tag_area">
                        <span>おすすめのタグ</span>
                        <?php foreach($tags as $tag): ?>
                            <a onclick="$('#tag_caption').val($('#tag_caption').val() + '#{{ $tag }} ');" href="javascript: void(0);">
                                <i class="fa fa-plus"></i>
                                <span>#{{ $tag }}</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        {!! Form::submit('upload', ['class' => 'btn btn-default']) !!}
                    </div>
                    {!! Form::close() !!}

                    <div class="form-group">
                        <button id="selectcurrentlocation"> select current location</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('js/script.js')}}"></script>
@endsection