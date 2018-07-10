@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <div class="clearfix content-top">
        <?php App\Helpers\Helper::UserList($follow); ?>
    </div>
</div>

@endsection

@section('js')

@endsection