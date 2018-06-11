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
                                <p id="lat_detail"><?php echo $content->lat; ?></p>
                                <p id="lng_detail"><?php echo $content->lng; ?></p>
                                <p id="lng_detail">{{ $content->address }}</p>
                                <p>spot_name: {{ $content->spot_name }}</p>
                            </div>
                        @endif

                        <body onload="content()"></body>
                        <div id="map_canvas" style="width:480px; height:300px"></div>
                        <!-- <button type="button" class="btn btn-default">
                            <a href="/content/{{ $content->id }}/route">get route by walk</a>
                        </button> -->
                        <!-- 現在地 lat lng -->
                        <input type="hidden" value="" id="currentLat">
                        <input type="hidden" value="" id="currentLng">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                var currentLat = $('#currentLat').val();
                                var currentLng = $('#currentLng').val();
                                var agent = navigator.userAgent;

                                if(agent.search(/iPhone/) != -1 || agent.search(/iPad/) != -1){
                                //iOSは標準のマップアプリ
                                    $("#js-access-map a").attr("href", "http://maps.apple.com/maps?saddr=&daddr={{ $content->lat }},{{ $content->lng }}&z=16");
                                }else{
                                //iOS以外はGoogleマップアプリ
                                    $("#js-access-map a").attr("href", "http://maps.google.com/maps?saddr=&daddr={{ $content->lat }},{{ $content->lng }}&z=16");
                                }
                            });
                        </script>
                        <p id="js-access-map"><a href="http://maps.google.com/maps?saddr=&daddr={{ $content->lat }},{{ $content->lng }}&z=16"><i class="fa fa-map-marker fa-fw"></i>地図アプリで道順を見る</a></p>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
