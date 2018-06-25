<?php

namespace App\Helpers;

class Helper
{
    /**
     * XXXする関数
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

    public static function ContentList($content)
    {
        $content = array_reverse($content);
        foreach($content as $v):
        ?>
            <a href="/content/<?php echo $v['id']; ?>">
                <div class="card_item">
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
                                    echo "<video class='card_item_img' src='/item/$img' controls></video>";
                                }
                                $i++;
                            }
                        }
                    ?>
                    <div class="card_item_detail">
                        <p class="card_item_name">spot_name:<?php echo $v['spot_name']; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach;
    }
}