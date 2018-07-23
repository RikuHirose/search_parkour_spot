<div class="notice-block">
	<a href="/user/{{ $notification->data['follower_id'] }}" class="img-user">
	<?php if($notification->data['user']['avatar_name'] == ''): ?>
	    <img src="/item/user-default.png" class="notice-user">
	<?php else: ?>

	    <?php if (Helper::isFB($notification->data['user']['avatar_name']) == true): ?>
	        <img src="<?php echo $notification->data['user']['avatar_name']; ?>" class="notice-user">
	    <?php else: ?>
	        <img src="https://s3-ap-northeast-1.amazonaws.com/pklinks/user/<?php echo $notification->data['user']['avatar_name']; ?>" class="notice-user">
	    <?php endif; ?>

	<?php endif; ?>
	</a>
	<div class="YFq-A">
	  <strong>
	    <a class="FPmhX notranslate yrJyr" href="/user/{{ $notification->data['follower_id'] }}">{{ $notification->data['follower_name'] }}</a>
	　</strong>さんがあなたをフォローしました。
	    <span class="date">
	    	<?php $noti_date = $notification->updated_at->toarray(); echo App\Helpers\Helper::convert_to_fuzzy_time($noti_date['formatted']); ?>
	    </span>
	</div>
	<div class="iTMfC">
	@if (auth()->user()->isFollowing($notification->data['follower_id']))
	        <form action="{{route('unfollow', ['id' => $notification->data['follower_id'] ]) }}" method="POST" class="notice-form">
	            {{ csrf_field() }}
	            {{ method_field('DELETE') }}
	            <!-- <input type="submit" id="delete-follow-{{ $notification->data['follower_id'] }}" class="action-wrap _8A5w5" value="フォロー中"> -->
	            <button type="submit" id="delete-follow-{{ $notification->data['follower_id'] }}" class="action-wrap _8A5w5">
	            	<span>フォロー中</span>
	            </button>
	        </form>
	@else
	        <form action="{{route('follow', ['id' => $notification->data['follower_id'] ]) }}" method="POST" class="notice-form">
	            {{ csrf_field() }}
	            <!-- <input type="submit" id="follow-user-{{ $notification->data['follower_id'] }}" class="action-wrap L3NKy" value="フォローする"> -->
	            <button type="submit" id="delete-follow-{{ $notification->data['follower_id'] }}" class="action-wrap L3NKy">
	            	<span>フォローする</span>
	            </button>
	        </form>
	@endif
	</div>
</div>