<?php

namespace App\Helpers;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
class Helper
{
    /**
     // viewのロジック
     *
     * @param string $value
     * @return string
     */


    public static function get_gps_from_address($address){
        $res = array();
        $req = 'http://maps.google.com/maps/api/geocode/xml';
        $req .= '?address='.urlencode($address);
        $req .= '&sensor=false';
        $xml = simplexml_load_file($req) or die('XML parsing error');
        if ($xml->status == 'OK') {
            $location = $xml->result->geometry->location;
            $res['lat'] = (string)$location->lat[0];
            $res['lng'] = (string)$location->lng[0];
        }
        return $res;
    }

    public static function isMobile()
    {

            $agent = new Agent();

            if ($agent->isMobile()) {
                return  true;
            } else {
                return false;
            }
    }

    public static function isUser($userid)
    {
        $id = Auth::user()->id;
        if($userid == $id) {
            return true;
        } else {
            return false;
        }
    }

    public static function judgeImgorVideo($value)
    {
        $file_info = pathinfo($value);
        $img_extension = strtolower($file_info['extension']);

        if ($img_extension == 'jpeg' || $img_extension == 'bmp' || $img_extension == 'png') {
            $value = 0;
        }elseif ($img_extension == 'mp4' || $img_extension == 'qt' || $img_extension == 'x-ms-wmv' || $img_extension == 'mpeg' || $img_extension == 'x-msvideo') {
            $value = 1;
        }
        return $value;
    }

    public static function regexTag($str)
    {
        preg_match_all('/[＃＃]([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);

        return $match;
    }

    public static function recommendTags()
    {
        $tags = ['SandyArea', 'Wall', 'Bar', 'Rail', 'Glass', 'Rocks', 'Gym', 'Trampoline', 'Precision', 'Plyometrics', 'Flow'];

        return $tags;
    }

    public static function ResultMore($content)
    {
        if(count($content) < 10): ?>

        <?php else: ?>
            <div id="more_btn">もっと見る <i class="fa fa-chevron-down" aria-hidden="true"></i></div>
            <div id="close_btn">表示数を戻す <i class="fa fa-chevron-up" aria-hidden="true"></i></div>
        <?php endif;
    }

    public static function avatarLogic($avatar_name)
    {
        if($avatar_name == ''): ?>
            <img src="/item/user-default.png" class="account-avatar">
        <?php else:
            if (Helper::isFB($avatar_name) == true): ?>
                <img src="<?php echo $avatar_name; ?>" class="account-avatar">
            <?php else: ?>
                <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $avatar_name; ?>" class="account-avatar">
            <?php endif; ?>
        <?php endif;
    }

    public static function avatarLogicEditor($avatar_name)
    {
        if($avatar_name == ''): ?>
            <img src="/item/user-default.png" class="avatar_name avatar-pos">
        <?php else:
            if (Helper::isFB($avatar_name) == true): ?>
                <img src="<?php echo $avatar_name; ?>" class="avatar_name avatar-pos">
            <?php else: ?>
                <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $avatar_name; ?>" class="avatar_name avatar-pos">
            <?php endif; ?>
        <?php endif;
    }

    public static function topbar_avatarLogic($avatar_name)
    {
        if($avatar_name == ''): ?>
            <img src="/item/user-default.png" class="avatar_name">
        <?php else:
            if (Helper::isFB($avatar_name) == true): ?>
                <img src="<?php echo $avatar_name; ?>" class="avatar_name">
            <?php else: ?>
                <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $avatar_name; ?>" class="avatar_name">
            <?php endif; ?>
        <?php endif;
    }

    public static function isFB($value)
    {

        $heystack = $value; // 捜査対象となる文字列
        $needle   = 'https://graph.facebook.com/v3.0/'; // 見つけたい文字列

        // 文字列が含まれるかどうかチェック

        if ( strpos( $heystack, $needle ) === false ) {
          return false;
        } else {
           return true;
        }
    }

    public static function convert_to_fuzzy_time($time_db){
        // $unix   = $time_db;
        // $now    = date("Y-m-d H:i:s");
        // echo $unix; echo $now;die;
        $unix   = strtotime($time_db);
        $now    = time();
        $diff_sec   = $now - $unix;


        if($diff_sec < 60){
            $time   = $diff_sec;
            $unit   = "秒前";
        }
        elseif($diff_sec < 3600){
            $time   = $diff_sec/60;
            $unit   = "分前";
        }
        elseif($diff_sec < 86400){
            $time   = $diff_sec/3600;
            $unit   = "時間前";
        }
        elseif($diff_sec < 2764800){
            $time   = $diff_sec/86400;
            $unit   = "日前";
        }
        else{
            if(date("Y") != date("Y", $unix)){
                $time   = date("Y年n月j日", $unix);
            }
            else{
                $time   = date("n月j日", $unix);
            }

            return $time;
        }

        return (int)$time .$unit;
    }

    public static function user_liked($notification)
    { ?>

    <div class="notice-block">

                <a class="" href="/user/{{ $notification->data['user_id'] }}">
                    <?php if($notification->data['avatar_name'] == ''): ?>
                        <img src="/item/user-default.png" class="notice-user">
                    <?php else: ?>
                        <?php if (Helper::isFB($notification->data['avatar_name']) == true): ?>
                            <img src="<?php echo $notification->data['avatar_name']; ?>" class="notice-user">
                        <?php else: ?>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $notification->data['avatar_name']; ?>" class="notice-user">
                        <?php endif; ?>
                    <?php endif; ?>
                </a>

        <div class="YFq-A">
            <a class="" title="{{ $notification->data['user_name'] }}" href="/user/{{ $notification->data['user_id'] }}">
                <strong><?php echo $notification->data['user_name']; ?></strong>
            </a>さんがあなたの投稿に「いいね！」しました。
        </div>
        <div class="iTMfC">
            <a class="" href="/content/<?php echo $notification->data['content_id']; ?>">
                        <?php
                        if(Helper::judgeImgorVideo($notification->data['img']) == 0) {
                            $img = $notification->data['img'];
                            echo "<img class='notice-img' src='$img'>";
                        } elseif(Helper::judgeImgorVideo($notification->data['img']) == 1) {
                            $img = $notification->data['img'];
                            echo "<video class='notice-img' src='$img'></video>";
                        }?>
            </a>
        </div>
    </div>
<?php
    }

    public static function commentTotag($comment)
    {
        $string = $comment;
        $pattern = '/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u';
        $replacement = '<a href="/search?q=${1}">#${1}</a>';
        $comment = preg_replace($pattern, $replacement, $string);

        return $comment;
    }

    public static function tagLogic($tag)
    {
        preg_match('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $tag, $match);?>
        <a href="/search?q=<?php echo $match[1]; ?>"><?php echo $tag; ?></a>
<?php
    }

    public static function UserList($users)
    { ?>
            <?php foreach($users as $user): ?>

                <div class="popular-wrap">
                    <a href="/user/<?php echo $user['id']; ?>">
                        <?php if($user['avatar_name'] == ''): ?>
                            <img src="/item/user-default.png" class="user-thumb">
                        <?php else: ?>

                            <?php if (\App\Helpers\Helper::isFB($user['avatar_name']) == true): ?>
                                <img src="<?php echo $user['avatar_name']; ?>" class="user-thumb">
                            <?php else: ?>
                                <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="user-thumb">
                            <?php endif; ?>
                        <?php endif; ?>
                            <div class="user-profile">
                                <p class="user-name"><?php echo $user['name']; ?></p>
                                <div class="user-info">
                                    <p><?php echo $user['comment']; ?></p>
                                </div>
                                <!-- <p>{{ $user['content_count'] }}</p> -->
                            </div>
                    </a>
                </div>
            <?php endforeach; ?>
    <?php
    }

    public static function SideUserList($users)
    { ?>
            <?php foreach($users as $user): ?>

                <div class="side-user-wrap">
                    <a href="/user/<?php echo $user['id']; ?>" class="clearfix">
                        <?php if($user['avatar_name'] == ''): ?>
                            <img src="/item/user-default.png" class="side_user-thumb">
                        <?php else: ?>

                            <?php if (\App\Helpers\Helper::isFB($user['avatar_name']) == true): ?>
                                <img src="<?php echo $user['avatar_name']; ?>" class="side_user-thumb">
                            <?php else: ?>
                                <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="side_user-thumb">
                            <?php endif; ?>
                        <?php endif; ?>
                            <div class="user-profile">
                                <span class="user-name"><?php echo $user['name']; ?></span>
                                <?php if(Helper::isMobile() == true): ?>
                                    <p class="po-u-section"><?php echo $user['comment']; ?></p>
                                <?php else: ?>
                                    <span class="po-u-section"><?php echo $user['comment']; ?></span>
                                <?php endif; ?>

                            </div>
                    </a>
                </div>
            <?php endforeach; ?>
    <?php
    }

    public static function RankingContentList($content)
    {
        // $content = array_reverse($content);
        $count = 0;
        foreach($content as $v): $count++; ?>
                <div class="main-content">
                    <div class="content-wrap">
                        <a href="/content/<?php echo $v['id']; ?>" class="">
                        <?php
                            $i = 0;
                            $num = 1;
                            foreach ($v['img'] as $img) {
                                if($i >= $num){
                                    break;
                                }else{
                                    if(Helper::judgeImgorVideo($img) == 0) {
                                        echo "<span class='ranking-num'>".$count."</span>";
                                        echo "<img class='ranking_img' src='$img'>";
                                    } elseif(Helper::judgeImgorVideo($img) == 1) {
                                        echo "<span class='ranking-num'>".$count."</span>";
                                        echo "<span class='ranking-video-icon'><i class='fas fa-video fa-2x fa-color'></i></span>";
                                        echo "<video class='ranking_video' src='$img'></video>";
                                    }
                                    $i++;
                                }
                            }
                        ?>
                        </a>
                    </div>
                    <div class="card_item_detail">
                        <div class="ranking_bottom clearfix">
                            <?php foreach($v['user'] as $user): ?>
                                <div>
                                    <!-- profile img -->
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php endif; ?>

                                    <?php endif; ?>
                                    <p class="user_name"><?php echo $user['name']; ?></p>
                                </div>
                            <?php endforeach; ?>
                            <div class="likes">
                                <img src="/item/like.png">
                                <p class="likes_count"><?php echo $v['likes_count']; ?></p>
                            </div>
                        </div>
                        <p class="ranking_item_name"><?php echo $v['spot_name']; ?></p>
                        <p class="ranking_address"><?php echo $v['address']; ?></p>
                        <p class="ranking_tag">
                        <?php
                            $i = 0;
                            $num = 6;
                            foreach($v['tags'] as $tag):
                                if($i >= $num):
                                    break;
                                else:
                                ?>
                                    <?php Helper::tagLogic($tag); $i++;?>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </p>
                    </div>
                </div>
        <?php endforeach;
    }

    public static function sideContentList($content)
    {

        foreach($content as $v):
        ?>
                <li id="content_list" class="bottom-content-list clearfix">
                    <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                        <div class="user-block">
                            <!-- <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name2">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php endif; ?>

                                    <?php endif; ?>
                            <?php endforeach; ?> -->
                        </div>
                    </a>
                    <div class="sidecontent-list">
                            <a href="/content/<?php echo $v['id']; ?>" class="">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2 card_item_img3' src='$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            echo "<video class='card_item_img2 card_item_img3' src='$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        <div class="side-right-box">
                            <h3 class="content-title content-new-title sidebar-title">
                                <?php echo $v['spot_name']; ?>
                            </h3>
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="distancespot">このスポットから<span class="spot-diastance"><?php echo $v['diastance']; ?>km<span></p>
                            <p class="spottag">
                                <?php
                                $i = 0;
                                $num = 4;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </p>
                        </div>
                    </div>
                </li>
            </a>
        <?php endforeach;
    }

    public static function SearchPlaceContentList($content, $query)
    {

        foreach($content as $v):
        ?>
                <div class="new-content-list clearfix" id="content_list">
                    <a href="/content/<?php echo $v['id']; ?>" class="">
                        <!-- <h3 class="content-title content-new-title">
                            <?php echo $v['spot_name']; ?>
                        </h3> -->
                        <!-- <div class="user-block"> -->
                            <!-- <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name2">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php endif; ?>

                                    <?php endif; ?>
                            <?php endforeach; ?> -->
                        <!-- </div> -->
                    </a>
                    <div class="content-list clearfix">
                        <div class="imglefter">
                            <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2' src='$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            // echo "<span class='new-video-icon'><i class='fas fa-video fa-2x fa-color'></i></span>";
                                            echo "<video class='card_item_img2' src='$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        </div>
                        <div class="content-list-text">
                            <a class="content-title content-new-title" href="/content/<?php echo $v['id']; ?>">
                                <?php echo $v['spot_name']; ?>
                            </a>
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="card_item_tag">「<?php echo $query; ?>」から<?php echo $v['diastance']; ?>km</p>
                            <p class="card_item_tag clearfix">
                                <?php
                                $i = 0;
                                $num = 4;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>

                            </p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach;
    }

    public static function mobileSearchPlaceContentList($content, $query)
    {

        foreach($content as $v):
        ?>
                <li id="content_list" class="bottom-content-list clearfix">
                    <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                        <div class="user-block">
                            <!-- <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name2">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php endif; ?>

                                    <?php endif; ?>
                            <?php endforeach; ?> -->
                        </div>
                    </a>
                    <div class="sidecontent-list">
                            <a href="/content/<?php echo $v['id']; ?>" class="">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2 card_item_img3' src='$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            echo "<video class='card_item_img2 card_item_img3' src='$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        <div class="side-right-box">
                            <h3 class="content-title content-new-title sidebar-title">
                                <?php echo $v['spot_name']; ?>
                            </h3>
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="spottag">
                                <?php
                                $i = 0;
                                $num = 4;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </p>
                        </div>
                    </div>
                </li>
            </a>
        <?php endforeach;
    }

    public static function mobileNewContentList($content)
    {
        $content = array_reverse($content);
        $content = array_slice($content, 0, 6);
        foreach($content as $v):
        ?>
                <li id="content_list" class="bottom-content-list clearfix">
                    <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                        <div class="user-block">
                            <!-- <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name2">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php endif; ?>

                                    <?php endif; ?>
                            <?php endforeach; ?> -->
                        </div>
                    </a>
                    <div class="sidecontent-list">
                            <a href="/content/<?php echo $v['id']; ?>" class="">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2 card_item_img3' src='$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            echo "<video class='card_item_img2 card_item_img3' src='$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        <div class="side-right-box">
                            <h3 class="content-title content-new-title sidebar-title">
                                <?php echo $v['spot_name']; ?>
                            </h3>
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="spottag">
                                <?php
                                $i = 0;
                                $num = 4;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </p>
                        </div>
                    </div>
                </li>
            </a>
        <?php endforeach;
    }
    public static function  NewContentList($content)
    {
        $content = array_reverse($content);
        $content = array_slice($content, 0, 6);
        foreach($content as $v):
        ?>
                <div class="new-content-list clearfix">
                    <a href="/content/<?php echo $v['id']; ?>" class="">
                        <!-- <h3 class="content-title content-new-title">
                            <?php echo $v['spot_name']; ?>
                        </h3> -->
                        <!-- <div class="user-block"> -->
                            <!-- <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name2">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php endif; ?>

                                    <?php endif; ?>
                            <?php endforeach; ?> -->
                        <!-- </div> -->
                    </a>
                    <div class="content-list clearfix">
                        <div class="imglefter">
                            <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2' src='$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            // echo "<span class='new-video-icon'><i class='fas fa-video fa-2x fa-color'></i></span>";
                                            echo "<video class='card_item_img2' src='$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        </div>
                        <div class="content-list-text">
                            <a class="content-title content-new-title" href="/content/<?php echo $v['id']; ?>">
                                <?php echo $v['spot_name']; ?>
                            </a>
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="card_item_tag clearfix">
                                <?php
                                $i = 0;
                                $num = 4;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>

                            </p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach;
    }

    public static function mobileSearchTagContentList($content)
    {
        foreach($content as $v):
        ?>
                <li id="content_list" class="bottom-content-list clearfix">
                    <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                        <div class="user-block">
                            <!-- <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name2">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php endif; ?>

                                    <?php endif; ?>
                            <?php endforeach; ?> -->
                        </div>
                    </a>
                    <div class="sidecontent-list">
                            <a href="/content/<?php echo $v['id']; ?>" class="">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2 card_item_img3' src='$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            echo "<video class='card_item_img2 card_item_img3' src='$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        <div class="side-right-box">
                            <h3 class="content-title content-new-title sidebar-title">
                                <?php echo $v['spot_name']; ?>
                            </h3>
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="spottag">
                                <?php
                                $i = 0;
                                $num = 4;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </p>
                        </div>
                    </div>
                </li>
            </a>
        <?php endforeach;
    }


    public static function SearchTagContentList($content)
    {
        // $content = array_reverse($content);
        // $content = array_slice($content, 0, 6);
        foreach($content as $v):
        ?>
                <div class="new-content-list clearfix" id="content_list">
                    <a href="/content/<?php echo $v['id']; ?>" class="">
                        <!-- <h3 class="content-title content-new-title">
                            <?php echo $v['spot_name']; ?>
                        </h3> -->
                        <!-- <div class="user-block"> -->
                            <!-- <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name2">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name2">
                                        <?php endif; ?>

                                    <?php endif; ?>
                            <?php endforeach; ?> -->
                        <!-- </div> -->
                    </a>
                    <div class="content-list clearfix">
                        <div class="imglefter">
                            <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2' src='$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            // echo "<span class='new-video-icon'><i class='fas fa-video fa-2x fa-color'></i></span>";
                                            echo "<video class='card_item_img2' src='$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        </div>
                        <div class="content-list-text">
                            <a class="content-title content-new-title" href="/content/<?php echo $v['id']; ?>">
                                <?php echo $v['spot_name']; ?>
                            </a>
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="card_item_tag clearfix">
                                <?php
                                $i = 0;
                                $num = 4;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>

                            </p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach;
    }

    public static function ResultContentList($content)
    {
        // $content = array_reverse($content);
        $count = 0;
        foreach($content as $v): $count++; ?>
                <div class="main-content">

                        <a href="/content/<?php echo $v['id']; ?>" class="">
                        <?php
                            $i = 0;
                            $num = 1;
                            foreach ($v['img'] as $img) {
                                if($i >= $num){
                                    break;
                                }else{
                                    if(Helper::judgeImgorVideo($img) == 0) {
                                        echo "<span class='ranking-num'>".$count."</span>";
                                        echo "<img class='ranking_img' src='/item/$img'>";
                                    } elseif(Helper::judgeImgorVideo($img) == 1) {
                                        echo "<span class='ranking-num'>".$count."</span>";
                                        echo "<span class='ranking-video-icon'><i class='fas fa-video fa-3x fa-color'></i></span>";
                                        echo "<div class='camera-position'><video class='ranking_video' src='/item/$img'></video></div>";
                                    }
                                    $i++;
                                }
                            }
                        ?>
                        </a>
                    <div class="card_item_detail">
                        <div class="ranking_bottom clearfix">
                            <?php foreach($v['user'] as $user): ?>
                                <div>
                                    <!-- profile img -->
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php else: ?>
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php endif; ?>

                                    <?php endif; ?>
                                    <p class="user_name"><?php echo $user['name']; ?></p>
                                </div>
                            <?php endforeach; ?>
                            <div class="likes">
                                <img src="/item/like.png">
                                <p class="likes_count"><?php echo $v['likes_count']; ?></p>
                            </div>
                        </div>
                        <p class="ranking_item_name"><?php echo $v['spot_name']; ?></p>
                        <p class="ranking_address"><?php echo $v['address']; ?></p>
                        <p class="ranking_tag">
                        <?php
                            $i = 0;
                            $num = 6;
                            foreach($v['tags'] as $tag):
                                if($i >= $num):
                                    break;
                                else:
                                ?>
                                    <?php Helper::tagLogic($tag); $i++;?>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </p>
                    </div>
                </div>
        <?php endforeach;
    }

}