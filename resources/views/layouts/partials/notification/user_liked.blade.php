


<div class="notice-block">

	<a href="/user/{{ $notification->data['user_id'] }}" class="img-user">
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
		<strong>
			<a class="FPmhX notranslate yrJyr" title="{{ $notification->data['user_name'] }}" href="/user/{{ $notification->data['user_id'] }}">{{ $notification->data['user_name'] }}</a>
		</strong>
		さんがあなたの動画に「いいね！」しました。
		<span class="date">
	    	<?php $noti_date = $notification->updated_at->toarray(); echo App\Helpers\Helper::convert_to_fuzzy_time($noti_date['formatted']); ?>
	    </span>
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
			</div>
		</a>
	</div>
</div>
