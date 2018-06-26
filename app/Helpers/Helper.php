<?php

namespace App\Helpers;

class Helper
{
    /**
     // viewのロジック
     *
     * @param string $value
     * @return string
     */
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

    public static function TwoColumnContentList($content)
    {
        $content = array_reverse($content);
        $i = 0;
        $v = 6;
        foreach($content as $v):
        ?>
        <?php if($i >= $v): break;?>
        <?php else: ?>
                <div class="main-content card_item">
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
                                        echo "<img class='card_item_img' src='/item/$img'>";
                                    } elseif(Helper::judgeImgorVideo($img) == 1) {
                                        echo "<div class='camera-position'><i class='fas fa-video fa-lg my-gray'></i></div><video class='card_item_img' src='/item/$img'></video>";
                                    }
                                    $i++;
                                }
                            }
                        ?>
                        </a>
                    </div>
                    <div class="card_item_detail">
                        <p class="card_item_name">spot_name:<?php echo $v['spot_name']; ?></p>
                        <p class="card_item_name"><?php echo $v['address']; ?></p>
                        <p class="card_item_name">
                            <?php foreach($v['tags'] as $tag): ?>
                                <?php echo $tag; ?>
                            <?php endforeach; ?>
                        </p>
                    </div>
                </div>
<!--                 <?php foreach ($v['img'] as $img): ?>
                <?php if(Helper::judgeImgorVideo($img) == 1): ?>
                    <i class='fas fa-video fa-lg my-gray'></i>
                <?php endif;?>
            <?php endforeach; ?> -->
        <?php endif; ?>
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
                        <div>
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
                        </div>
                        <div class="content-list-text">
                            <p class="card_item_text"><?php echo $v['address']; ?></p>
                            <p class="card_item_text">このスポットから~km</p>
                            <p class="card_item_text">
                                <?php foreach($v['tags'] as $tag): ?>
                                    <?php echo $tag; ?>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach;
    }
}