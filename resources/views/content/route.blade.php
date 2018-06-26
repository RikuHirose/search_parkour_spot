@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <input type="hidden" value="<?php echo $content->id; ?>" id="id">
                    <input type="hidden" value="<?php echo $content->lat; ?>" id="lat">
                    <input type="hidden" value="<?php echo $content->lng; ?>" id="lng">


                    <body onload="route()"></body>
                    <div id="map_canvas" class="map_canvas"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
