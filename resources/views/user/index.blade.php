@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <div class="user">
            <div class="user-top clearfix">
                <div class="user-img">
                    <?php \App\Helpers\Helper::avatarLogic($user['avatar_name']) ?>
                </div>
                <div class="user-info">
                    <p class="user-posts"><span><?php echo count($content); ?></span>posts</p>
                    <a class="user-followers" href="/user/{{ $user['id'] }}/followerlist">
                        <span><?php echo count($followers); ?></span>followers
                    </a>
                    <a class="user-follows" href="/user/{{ $user['id'] }}/followlist">
                        <span><?php echo count($follows); ?></span>follows
                    </a>
                    <div class="user-btn">
                            <!-- ログインしているuserか判定する -->
                            @auth
                                <?php if (Auth::user()->id != $user['id']): ?>
                                        @if (auth()->user()->isFollowing($user['id']))
                                                <form action="{{route('unfollow', ['id' => $user['id'] ]) }}" method="POST" class="">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <input type="submit" id="delete-follow-{{ $user['id'] }}" class="action-wrap" value="Unfollow">
                                                </form>
                                        @else
                                                <form action="{{route('follow', ['id' => $user['id'] ]) }}" method="POST" class="">
                                                    {{ csrf_field() }}
                                                    <input type="submit" id="follow-user-{{ $user['id'] }}" class="action-wrap" value="Follow">
                                                </form>
                                        @endif
                                <?php elseif(Auth::user()->id == $user['id']): ?>
                                    <a  href="/user/<?php echo $user['id']; ?>/edit">
                                        <button class="action-wrap">edit profile</button>
                                    </a>
                                <?php endif; ?>

                            @endauth
                            @guest
                            <a  href="/login">
                                <button class="action-wrap">フォローする</button>
                            </a>
                            @endguest
                    </div>
                </div>
            </div>
            <div class="user-bottom">
                <p><?php echo $user['name']; ?></p>
                <p>
                    <?php
                        $string = $user['comment'];
                        $pattern = '/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u';
                        $replacement = '<a href="/search?tag=${1}">#${1}</a>';
                        $replacement2 = '${1}';
                        echo preg_replace($pattern, $replacement, $string);
                    ?>
                </p>
            </div>
            <div class="card-header result-icons">
                <a href="/user/<?php echo $user['id']; ?>" id="result-index" class="switch-left switch-bottom"><i class="fa fa-list-ul fa-3x"></i></a>
                <a href="/user/<?php echo $user['id']; ?>/map" id="result-map"><i class="fa fa-map-marker-alt fa-3x"></i></a>
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