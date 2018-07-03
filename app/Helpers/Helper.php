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

    public static function tagLogic($tag)
    {
        preg_match('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $tag, $match);?>
        <a href="/search?tag=<?php echo $match[1]; ?>"><?php echo $tag; ?></a>
<?php
    }

    public static function RankingContentList($content)
    {
        // $content = array_reverse($content);
        $count = 0;
        foreach($content as $v): $count++; ?>
                <div class="main-content">
                    <div>
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
                    </div>
                    <div class="card_item_detail">
                        <p class="ranking_item_name"><?php echo $v['spot_name']; ?></p>
                        <p class="ranking_address"><?php echo $v['address']; ?></p>
                        <p class="ranking_tag">
                            <?php foreach($v['tags'] as $tag): ?>
                                <?php Helper::tagLogic($tag); ?>
                            <?php endforeach; ?>
                        </p>
                        <div class="ranking_bottom clearfix">
                            <p><img src="/item/like.png"></p>
                            <p class="likes_count"><?php echo $v['likes_count']; ?></p>
                                <?php foreach($v['user'] as $user): ?>

                                    <!-- profile img -->
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php else: ?>
                                            <img src="/item/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php endif; ?>

                                    <?php endif; ?>
                                    <!-- <p class="user_name"><?php echo $user['name']; ?></p> -->
                                <?php endforeach; ?>
                        </div>
                    </div>
                </div>
        <?php endforeach;
    }

    public static function OneColumnContentList($content)
    {
        $content = array_reverse($content);
        foreach($content as $v):
        ?>
                <div class="bottom-content-list">
                    <a href="/content/<?php echo $v['id']; ?>" class="main-content card_item">
                        <h3 class="content-title">
                            <?php echo $v['spot_name']; ?>
                        </h3>
                    </a>
                    <div class="content-list">
                            <a href="/content/<?php echo $v['id']; ?>" class="main-content card_item">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2' src='/item/$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            echo "<video class='card_item_img2' src='/item/$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        <div class="content-list-text">
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="card_item_text">このスポットから<?php echo $v['diastance']; ?>km</p>
                            <p class="card_item_text">
                                <?php foreach($v['tags'] as $tag): ?>
                                    <?php Helper::tagLogic($tag); ?>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach;
    }

    public static function TopOneColumnContentList($content)
    {
        $content = array_reverse($content);
        $content = array_slice($content, 0, 6);
        foreach($content as $v):
        ?>
                <div class="bottom-content-list">
                    <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                        <h3 class="content-title">
                            <?php echo $v['spot_name']; ?>
                        </h3>
                    </a>
                    <div class="content-list">
                        <div>
                            <a href="/content/<?php echo $v['id']; ?>" class="card_item">
                            <?php
                                $i = 0;
                                $num = 1;
                                foreach ($v['img'] as $img) {
                                    if($i >= $num){
                                        break;
                                    }else{
                                        if(Helper::judgeImgorVideo($img) == 0) {
                                            echo "<img class='card_item_img2' src='/item/$img'>";
                                        } elseif(Helper::judgeImgorVideo($img) == 1) {
                                            echo "<video class='card_item_img2' src='/item/$img'></video>";
                                        }
                                        $i++;
                                    }
                                }
                            ?>
                            </a>
                        </div>
                        <div class="content-list-text">
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="card_item_text clearfix">
                                <?php
                                $i = 0;
                                $num = 5;
                                foreach($v['tags'] as $tag):
                                    if($i >= $num):
                                        break;
                                    else:
                                    ?>
                                        <?php Helper::tagLogic($tag); $i++;?>
                                    <?php endif; ?>
                                <?php endforeach;?>

                                <?php foreach($v['user'] as $user): ?>
                                    <?php if($user['avatar_name'] == ''): ?>
                                        <img src="/item/user-default.png" class="top_avatar_name">
                                    <?php else: ?>

                                        <?php if (Helper::isFB($user['avatar_name']) == true): ?>
                                            <img src="<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php else: ?>
                                            <img src="/item/user/<?php echo $user['avatar_name']; ?>" class="top_avatar_name">
                                        <?php endif; ?>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach;
    }
}