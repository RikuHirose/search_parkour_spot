
<a href="/user/{{ $notification->data['user_id'] }}">
	{{ $notification->data['content_id'] }}
	{{ $notification->data['avatar_name'] }}
	{{ $notification->data['img'] }}
	{{ $notification->data['user_name'] }}
</a>



<div class="PUHRj  H_sJK" role="button">
	<div class="cek9Q">
		<div class="H59PT">
			<a class="_2dbep qNELH kIKUG" href="/user/{{ $notification->data['user_id'] }}" style="width: 34px; height: 34px;">
				<img class="_6q-tv" src="{{ $notification->data['avatar_name'] }}" alt="{{ $notification->data['user_name'] }}さんのプロフィール写真">
			</a>
		</div>
	</div>
	<div class="YFq-A">
		<a class="FPmhX notranslate yrJyr" title="{{ $notification->data['user_name'] }}" href="/user/{{ $notification->data['user_name'] }}">{{ $notification->data['user_name'] }}</a>さんがあなたの動画に「いいね！」しました。
	</div>
	<div class="iTMfC">
		<a class="kIKUG H-dnq" href="/content/{{ $notification->data['content_id'] }}">
			<div class="eLAPa GzVn2" role="button">
				<div class="KL4Bh">
					<img class="FFVAD" decoding="auto" sizes="40px" src="" style="{{ $notification->data['img'] }}">
				</div>
				<div class="_9AhH0">
					
				</div>
			</div>
		</a>
	</div>
</div>
