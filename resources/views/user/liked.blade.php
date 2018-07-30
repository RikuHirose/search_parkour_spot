@extends('layouts.app')

@section('title')
    いいねした投稿一覧   |
@endsection

@section('css')
<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="wrap">
    <?php if(App\Helpers\Helper::isMobile() == true): ?>
        <div class="user">
                <div class="user-top clearfix nosee">
                    <p>「いいね!」した投稿です。他の人には表示されません。</p>
                </div>
                <div class="card-header result-icons">
                    <a href="/user/<?php echo $user['id']; ?>/liked" id="result-index" class="switch-left switch-bottom"><i class="fa fa-list-ul fa-3x"></i></a>
                    <a href="/user/<?php echo $user['id']; ?>/liked/map" id="result-map"><i class="fa fa-map-marker-alt fa-3x"></i></a>
                </div>
        </div>
    <?php elseif(App\Helpers\Helper::isMobile() == false): ?>
        <div class="user">
                <div class="user-top clearfix nosee">
                    「いいね!」した投稿です。他の人には表示されません。
                </div>
                <div class="card-header result-icons">
                    <a href="/user/<?php echo $user['id']; ?>/liked" id="result-index" class="switch-left switch-bottom"><i class="fa fa-list-ul fa-3x"></i></a>
                    <a href="/user/<?php echo $user['id']; ?>/liked/map" id="result-map"><i class="fa fa-map-marker-alt fa-3x"></i></a>
                </div>
        </div>
    <?php endif; ?>

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
                            echo "<img class='card_item_list2 imgcoverstyle' src='$img'>";
                        } elseif(App\Helpers\Helper::judgeImgorVideo($img) == 1) {
                            echo "<span class='video-icon'><i class='fas fa-video fa-2x fa-color'></i></span>";
                            echo "<video class='card_item_list2 video-back' src='$img'></video>";
                        }
                        $i++;
                        ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            </a>
            <?php endforeach; ?>
        <!-- pc -->
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
                            echo "<img class='content-size2 imgcoverstyle' src='$img'>";
                        } elseif(App\Helpers\Helper::judgeImgorVideo($img) == 1) {
                            echo "<span class='video-icon'><i class='fas fa-video fa-2x fa-color'></i></span>";
                            echo "<video class='content-size2 video-back' src='$img'></video>";
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

<script src="{{asset('js/iziModal.min.js')}}"></script>
@endsection