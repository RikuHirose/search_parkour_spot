@extends('layouts.app')

@section('content')

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
                    <div id="map_canvas" class="map_canvas"></div>
                    <button id="getcurrentlocation">getcurrentlocation</button>
                </div>
            </div>

@endsection

@section('js')
<script src="{{asset('js/index.js')}}"></script>
@endsection