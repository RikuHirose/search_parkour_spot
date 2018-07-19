


<div class="PUHRj  H_sJK" role="button">
	<div class="cek9Q">
		<div class="H59PT">
			<a class="_2dbep qNELH kIKUG" href="/user/{{ $notification->data['user_id'] }}">
				<?php if($notification->data['avatar_name'] == ''): ?>
                    <img src="/item/user-default.png" class="notice-user">
                <?php else: ?>
                    <?php if (\App\Helpers\Helper::isFB($notification->data['avatar_name']) == true): ?>
                        <img src="<?php echo $notification->data['avatar_name']; ?>" class="notice-user">
                   	<?php else: ?>
						<img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $notification->data['avatar_name']; ?>" class="notice-user">
                    <?php endif; ?>
                <?php endif; ?>
			</a>
		</div>
	</div>
	<div class="YFq-A">
		<a class="FPmhX notranslate yrJyr" title="{{ $notification->data['user_name'] }}" href="/user/{{ $notification->data['user_id'] }}">{{ $notification->data['user_name'] }}</a>さんがあなたの動画に「いいね！」しました。
	</div>
	<div class="iTMfC">
		<a class="kIKUG H-dnq" href="/content/{{ $notification->data['content_id'] }}">
			<div class="eLAPa GzVn2" role="button">
				<div class="KL4Bh">
					<?php
					if(App\Helpers\Helper::judgeImgorVideo($notification->data['img']) == 0) {
						$img = $notification->data['img'];
                        echo "<img class='notice-img' src='$img'>";
                    } elseif(App\Helpers\Helper::judgeImgorVideo($notification->data['img']) == 1) {
                    	$img = $notification->data['img'];
                       	echo "<video class='notice-img' src='$img'></video>";
                    }?>

				</div>
				<div class="_9AhH0">
					
				</div>
			</div>
		</a>
	</div>
</div>
