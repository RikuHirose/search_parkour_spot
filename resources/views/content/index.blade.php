@extends('layouts.app')

@section('title')
    Mapから探す   |
@endsection

@section('css')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
            <div class="card">
                <div class="card-body">
	                <div id="map_canvas" class="map_canvas"></div>
	                <div id="getcurrentlocation" class="get-current">
                            <p class="current-p acbtn">現在地を取得する</p>
                    </div>
	            </div>

            </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/index.js')}}"></script>
@endsection