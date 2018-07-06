@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <div class="user">
        <div class="user-top clearfix">
            <div class="user-img">
                <?php App\Helpers\Helper::avatarLogic($user['avatar_name']) ?>
            </div>
            <div class="user-info">
                <p><span>{{ count($content) }}</span>posts</p>
                <div class="user-btn">
                        <!-- ログインしているuserか判定する -->
                        @auth
                            <?php if (Auth::user()->id != $user['id']): ?>
                                <p>aa</p>
                            <?php elseif(Auth::user()->id == $user['id']): ?>
                                <a href="/user/{{ $user['id'] }}/edit">edit profile</a>
                            <?php endif; ?>
                        @endauth
                </div>
            </div>
        </div>
        <div class="user-bottom">
            <p>{{ $user['name'] }}</p>
            <p>{{ $user['comment'] }}</p>
        </div>
        <div class="card-header result-icons">
            <a href="/user/{{ $user['id'] }}" id="result-index" class="switch-left switch-bottom"><i class="fa fa-list-ul fa-3x"></i></a>
            <a href="/user/{{ $user['id'] }}/map" id="result-map"><i class="fa fa-map-marker-alt fa-3x"></i></a>
        </div>

    </div>
    <div class="content">
        <?php if(App\Helpers\Helper::isMobile() == true): ?>
            <?php foreach($content as $v): ?>
            <?php
                $i = 0;
                $num = 1;
            ?>
            <a href="/content/{{ $v['id'] }}" class="card_item_list">
                <?php foreach($v['img'] as $img): if($i >= $num): break; ?>
                    <?php else: ?>
                        <?php if(App\Helpers\Helper::judgeImgorVideo($img) == 0) {
                            echo "<img class='card_item_list2' src='/item/$img'>";
                        } elseif(App\Helpers\Helper::judgeImgorVideo($img) == 1) {
                            echo "<span class='video-icon'><i class='fas fa-video fa-2x fa-color'></i></span>";
                            echo "<video class='card_item_list2 video-back' src='/item/$img'></video>";
                        }
                        $i++;
                        ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach($content as $v): ?>
            <?php
                $i = 0;
                $num = 1;
            ?>
            <a href="/content/{{ $v['id'] }}" class="content-size">
                <?php foreach($v['img'] as $img): if($i >= $num): break; ?>
                    <?php else: ?>
                        <?php if(App\Helpers\Helper::judgeImgorVideo($img) == 0) {
                            echo "<img class='content-size2' src='/item/$img'>";
                        } elseif(App\Helpers\Helper::judgeImgorVideo($img) == 1) {
                            echo "<span class='video-icon'><i class='fas fa-video fa-3x fa-color'></i></span>";
                            echo "<video class='content-size2 video-back' src='/item/$img'></video>";
                        }
                        $i++;
                        ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

@endsection

@section('js')

@endsection