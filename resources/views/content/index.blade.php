@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <!-- {!! Form::open(['url' => '/upload', 'method' => 'post', 'files' => true]) !!} -->

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
                        <button id="getcurrentlocation"> get current location</button>
                    </div>
                    <body onload="indexmap()"></body>
                    <div id="map_canvas" style="width:480px; height:300px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
