@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <form method="post" action="/user/{{ $user['id'] }}/edit/updateimg" files="true" enctype="multipart/form-data">
        {{ csrf_field() }}

        <?php if($user['avatar_name'] == ''): ?>
                <img src="/item/user-default.png" class="avatar_name">
        <?php else: ?>
                @if (App\Helpers\Helper::isFB($user['avatar_name']) == true)
                    <img src="{{ $user['avatar_name'] }}" class="avatar_name">
                @else
                    <img src="/item/user/{{ $user['avatar_name'] }}" class="avatar_name">
                @endif
        <?php endif; ?>


        edit profile img
        <input type="file" class="" name="avatar_name">
        <input type="submit" value="updateimg">

    </form>
    <!-- delete -->
        <form method="POST" action="/user/{{ $user['id'] }}/delete/deleteimg" files="true" enctype="multipart/form-data">
            {{ csrf_field() }}

                {!! Form::hidden('id',$user['id']) !!}
                {!! Form::hidden('avatar_name',$user['avatar_name']) !!}
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