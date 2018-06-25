@extends('layouts.app')

@section('content')

<div class="container">

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
                div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group clearfix">
                <h2>#new</h2>
                <?php App\Helpers\Helper::ContentList($content); ?>
            </div>
            <div class="form-group clearfix">
                <h2>#popular</h2>
            </div>
            <div class="form-group clearfix">
                <h2>#area</h2>
            </div>
            <div class="form-group clearfix">
                <h2>#area 現在地周辺のスポット</h2>

            </div>

        </div>
    </div>
</div>


@endsection
