@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <?php App\Helpers\Helper::avatarLogic($user['avatar_name']) ?>
    <form method="post" action="/user/{{ $user['id'] }}/edit/updateimg" files="true" enctype="multipart/form-data">
        {{ csrf_field() }}

        edit profile img
        <input type="file" class="" name="avatar_name">
        <input type="submit" value="updateimg">

    </form>
    <!-- delete -->
        <form method="POST" action="/user/{{ $user['id'] }}/delete/deleteimg" files="true" enctype="multipart/form-data">
            {{ csrf_field() }}

                {!! Form::hidden('id',$user['id']) !!}
                <input type="hidden" name="avatar_name" value="">
                <input type="submit" value="deleteimg">

        </form>
    <br>


    <form method="post" action="/user/{{ $user['id'] }}/edit/update">
        {{ csrf_field() }}

        <input type="text" name="name" value="{{ $user['name'] }}" placeholder="name">
        <input type="email" name="email" value="{{ $user['email'] }}" placeholder="email">
        <input type="text" name="comment" value="{{ $user['comment'] }}" placeholder="comment">

        <input type="submit" value="update">
    </form>
</div>

@endsection

@section('js')

@endsection