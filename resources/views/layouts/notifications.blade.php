@extends('layouts.app')


@section('css')
<link href="{{ asset('css/notification.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="top-display">
  @if (session('success'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ session('success') }}
    </div>
  @endif
</div>

<div class="wrap">
    <div class="card ">

      @forelse($notifications as $notification)
            <?php if(snake_case(class_basename($notification->type)) == 'user_liked'): ?>
              <div class="dpd-menu-li">
                <?php App\Helpers\Helper::user_liked($notification); ?>
              </div>

            <?php elseif(snake_case(class_basename($notification->type)) == 'user_followed'): ?>
              <div class="dpd-menu-li">
                <div class="notice-block">
                  <a href="/user/{{ $notification->data['follower_id'] }}">
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
                        <a href="/user/{{ $notification->data['follower_id'] }}">{{ $notification->data['follower_name'] }}</a></strong>さんがあなたをフォローしました。
                  </div>
                  <div class="iTMfC">
                    @if (auth()->user()->isFollowing($notification->data['follower_id']))
                            <form action="{{route('unfollow', ['id' => $notification->data['follower_id'] ]) }}" method="POST" class="">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="submit" id="delete-follow-{{ $notification->data['follower_id'] }}" class="action-wrap _8A5w5" value="フォロー中">
                                <!-- <button type="submit" id="delete-follow-{{ $notification->data['follower_id'] }}" class="action-wrap _8A5w5">フォロー中</button> -->
                            </form>
                    @else
                            <form action="{{route('follow', ['id' => $notification->data['follower_id'] ]) }}" method="POST" class="">
                                {{ csrf_field() }}
                                <input type="submit" id="follow-user-{{ $notification->data['follower_id'] }}" class="action-wrap L3NKy" value="フォローする">
                                <!-- <button type="submit" id="delete-follow-{{ $notification->data['follower_id'] }}" class="action-wrap _8A5w5">フォローする</button> -->
                            </form>
                    @endif
                  </div>
                </div>
              </div>
              <?php endif;  ?>
              @empty
                <div class="notice-block">
                  <a href="#">No notifications</a>
                </div>
      @endforelse


    </div>
</div>

@endsection

@section('js')
<!-- <script src="{{asset('js/searchBox.js')}}"></script> -->

@endsection
