@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <div class="clearfix">
        <div class="img-section">
            <?php App\Helpers\Helper::avatarLogic($user['avatar_name']) ?>
        </div>
        <div class="img-modal">
            <p>{{ $user['name'] }}</p>
            <p  class="modal-open">プロフィール写真を編集する</p>
        </div>
    </div>
    <div id="modal">
        <div class="iziModal-content">
            <a data-izimodal-close="">×</a>
            <!-- modal -->
            <div class="select-modal">
                <form method="post" action="/user/{{ $user['id'] }}/edit/updateimg" files="true" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    edit profile img
                    <input type="file" class="" name="avatar_name">
                    <input type="submit" value="updateimg">

                </form>
                <form method="POST" action="/user/{{ $user['id'] }}/delete/deleteimg" files="true" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    {!! Form::hidden('id',$user['id']) !!}
                    <input type="hidden" name="avatar_name" value="">
                    <input type="submit" value="deleteimg">

                </form>
            </div>
        </div>
    </div>

    <div class="edit-user-info">
        <div class="card-body">
            <form method="post" action="/user/{{ $user['id'] }}/edit/update">
                {{ csrf_field() }}
                <div class="form-item">
                    <aside><label>名前</label></aside>
                    <input type="text" name="name" value="{{ $user['name'] }}" placeholder="name">
                </div>
                <div class="form-item">
                    <aside><label>メールアドレス</label></aside>
                    <input type="email" name="email" value="{{ $user['email'] }}" placeholder="email">
                </div>
                <div class="form-item">
                    <aside><label>自己紹介</label></aside>
                    <input type="text" name="comment" value="{{ $user['comment'] }}" placeholder="comment">
                </div>
                <div class="form-item">
                    <input type="submit" value="update">
                </div>
            </form>
        </div>
    </div>
    @if (session('success'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('success') }}
    </div>
    @endif
    @if (session('fail'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('fail') }}
    </div>
    @endif
</div>
@endsection

@section('js')

<script src="{{asset('js/iziModal.min.js')}}"></script>

@endsection