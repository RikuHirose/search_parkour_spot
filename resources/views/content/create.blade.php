@extends('layouts.app')

@section('title')
    投稿する   |
@endsection

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">


@endsection

<!-- contentの読み込み -->
@section('content')
    <div class="wrap">
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
            <div class="card">
                <div class="card-body up-body">

                    {!! Form::open(['url' => '/content/store', 'method' => 'post', 'files' => true, 'name' => 'post', 'id' => 'fileupload']) !!}
                    {{ csrf_field() }}

                    <div class="form-group up-container">
                        <div class="l-post-form__top__image" id="form-image">
                            <div class="upload-wrapper">
                                <p class="preview" id="preview1">
                                    <span class="preview-delete"></span>
                                </p>
                                <p class="image-upload">
                                    <button for="photo" class="image-upload-button c-button acbtn" type="button">ファイルを選択(4つまで)</button>
                                    <input  id="upload" type="file" class="img-upload-input" name="files[][photo]" multiple="multiple">
                                </p>
                            </div>
                        </div>

                        <!-- <label for="photo">画像ファイル（複数可）:</label>
                        <input type="file" class="form-control" name="files[][photo]" multiple="multiple"> -->
                    </div>
                    <div class="form-group up-container">
                        <input type="text" name="spot_name" class="spot_name" value="{{ Input::old('spot_name') }}" placeholder="spot_name">
                        <textarea class="comment-area" name="comment" rows="4" cols="40" placeholder="キャプションを書く" id="tag_caption">{{ Input::old('comment') }}</textarea>

                        <div class="tag_area">
                            <span>おすすめのタグ</span>
                            <?php
                            $recommendtags = App\Helpers\Helper::recommendTags();
                            foreach($recommendtags as $tag): ?>
                                <a onclick="$('#tag_caption').val($('#tag_caption').val() + '#{{ $tag }} ');" href="javascript: void(0);" class="rectags">
                                    <i class="fa fa-plus"></i>
                                    <span>#{{ $tag }}</span>
                                </a>
                            <?php endforeach; ?>
                            <!-- <a onclick="$('#tag_caption').val($('#tag_caption').val() + '#Sandy Area');" href="javascript: void(0);">
                                    <i class="fa fa-plus"></i>
                                    <span>#SandyArea</span>
                            </a> -->
                        </div>
                        <p class="map-des">地図をクリックすると位置を指定できます。</p>
                        <table class="info-latlng">
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

                        <p>地名などから検索する</p>
                        <input id="map-input" class="controls search-box" type="text" placeholder="(例):渋谷">
                        <div id="map_canvas" class="map_canvas"></div>
                        <div id="selectcurrentlocation" class="get-current">
                            <p class="current-p acbtn">現在地を取得する</p>
                        </div>
                    </div>

                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <input  id="upload-btn" class="upload-btn acbtn" type="button" value="upload">
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>

    </div>
@endsection

@section('js')
<script>
    $(function(){
        $('#upload-btn').click(function(){
            $('form#fileupload').submit();
        });
    });
</script>
<script src="{{asset('js/create.js')}}"></script>
<script src="{{asset('js/validate_file.js')}}"></script>
<script src="{{asset('js/jquery.upload_thumbs.js')}}"></script>
<script>
$(function() {
    // jQuery Upload Thumbs 
    $('#upload').uploadThumbs({
        position : '#preview1',   // any: arbitrarily jquery selector
    });

});
</script>


@endsection