@extends('layouts.app')

<!-- cssの読み込み -->
@section('css')
<link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="top-display">
    <form action="/search" method="get" style="clear: both;">
        <input type="search" name="q" placeholder="気になるワードを入力">
        <input type="submit" class="search form-btn btn-green" value="検索">
    </form>
</div>

<div class="wrap">
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


            <h2>#ranking</h2>
            <div class="form-group clearfix">
                <?php App\Helpers\Helper::TwoColumnContentList($ranking); ?>
            </div>
            <h2>#new</h2>
            <div class="form-group clearfix">
                <?php App\Helpers\Helper::OneColumnContentList($content); ?>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')

@endsection
