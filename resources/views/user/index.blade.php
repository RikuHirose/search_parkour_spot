@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <div class="user">
        <div class="user-top clearfix">
            <div class="user-img">
                <?php if($user['avatar_name'] == 1): ?>
                    <img src="" class="avatar_name">
                <?php else: ?>
                    <img src="{{ $user['avatar_name'] }}" class="avatar_name">
                <?php endif; ?>
            </div>
            <div class="user-info">
                <p><span>{{ count($content) }}</span>posts</p>
                <div class="user-btn">
                    <a href="">
                        <!-- ログインしているuserか判定する -->
                        @guest
                            <p>aa</p>
                        @else
                            <p>edit profile</p>
                        @endguest
                    </a>
                </div>
            </div>
        </div>
        <div class="user-bottom">
            <p>{{ $user['name'] }}</p>
            <p></p>
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