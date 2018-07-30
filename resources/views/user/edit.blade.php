@extends('layouts.app')

@section('title')
    プロフィールを編集する   |
@endsection

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap user-container">
    <?php if(App\Helpers\Helper::isMobile() == false): ?>
        <div class="clearfix">
            <div class="img-section">
                <?php App\Helpers\Helper::avatarLogicEditor($user['avatar_name']) ?>
            </div>
            <div class="img-modal">
                <p class="modal-open modal-pos acbtn imhedpos">プロフィール写真を編集する</p>
            </div>
        </div>
    <?php elseif(App\Helpers\Helper::isMobile() == true): ?>
        <div class="clearfix img-pad">
            <div class="img-section">
                <?php App\Helpers\Helper::avatarLogicEditor($user['avatar_name']) ?>
            </div>
            <div class="img-modal">
                <span class="modal-open modal-pos acbtn imhedpos">プロフィール写真を編集する</span>
            </div>
        </div>
    <?php endif; ?>
    <div id="modal">
        <div class="iziModal-content">
            <a data-izimodal-close="" class="modal-close">×</a>
            <!-- modal -->
            <div class="select-modal">
                <h3 class="ch-profile">プロフィール写真を変更する</h3>
                <form method="post" action="/user/{{ $user['id'] }}/edit/updateimg" files="true" enctype="multipart/form-data" class="acbtn ">
                    {{ csrf_field() }}

                    <input type="file" name="avatar_name" class="upposition">
                    <input type="submit" value="写真をアップロード" class="imgsub imgup deletebtn-modal">

                </form>
                <form method="POST" action="/user/{{ $user['id'] }}/delete/deleteimg" files="true" enctype="multipart/form-data" class="acbtn deletebtn-modal">
                    {{ csrf_field() }}

                    {!! Form::hidden('id',$user['id']) !!}
                    <input type="hidden" name="avatar_name" value="">
                    <input type="submit" value="現在の写真を削除" class="imgsub imgdel">

                </form>
            </div>
        </div>
    </div>
<?php if(App\Helpers\Helper::isMobile() == false): ?>
    <div class="edit-user-info">
        <div class="card-body">
            <form method="post" action="/user/{{ $user['id'] }}/edit/update">
                {{ csrf_field() }}
                <div class="form-item">
                    <label class="label-pos">名前</label>
                    <input type="text" name="name" value="{{ $user['name'] }}" placeholder="name">
                </div>
                <div class="form-item">
                    <label class="label-pos">メールアドレス</label>
                    <input type="email" name="email" value="{{ $user['email'] }}" placeholder="email">
                </div>
                <div class="form-item">
                    <label class="label-pos">自己紹介</label>
                    <input type="text" name="comment" value="{{ $user['comment'] }}" placeholder="comment">
                    <!-- <textarea type="text" name="comment" placeholder="comment">{{ $user['comment'] }}</textarea> -->
                </div>
                <div class="form-item">
                    <input type="submit" value="update" class="acbtn" >
                </div>
            </form>

            <form method="post" action="/user/{{ $user['id'] }}/delete">
                {{ csrf_field() }}
                <div class="form-item">
                    <input type="submit" value="このアカウントを削除する" class="acbtn" >
                </div>
            </form>
        </div>
    </div>
<?php elseif(App\Helpers\Helper::isMobile() == true): ?>
    <div class="edit-user-info">
        <div class="card-body">
            <form method="post" action="/user/{{ $user['id'] }}/edit/update">
                {{ csrf_field() }}
                <div class="form-item">
                    <span class="rubi-pos">名前</span>
                    <input type="text" name="name" value="{{ $user['name'] }}" placeholder="name">
                </div>
                <div class="form-item">
                    <span class="rubi-pos">メールアドレス</span>
                    <input type="email" name="email" value="{{ $user['email'] }}" placeholder="email">
                </div>
                <div class="form-item">
                    <span class="rubi-pos">自己紹介</span>
                    <input type="text" name="comment" value="{{ $user['comment'] }}" placeholder="comment">

                </div>
                <div class="form-item">
                    <input type="submit" value="update" class="acbtn" >
                </div>
            </form>

            <form method="post" action="/user/{{ $user['id'] }}/delete" onsubmit="return check()">
                <div class="form-item">
                    <input type="submit" value="このアカウントを削除する" class="acbtn" >
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
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

<script>

function check(){

if(window.confirm('本当にこのアカウントを削除しますか？')){
        return true;
    }
    else{
        window.alert('キャンセルされました');
        return false;
    }
}

</script>

<script src="{{asset('js/iziModal.min.js')}}"></script>

@endsection