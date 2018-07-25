<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\Tag;
use App\Like;
use App\Notifications\UserFollowed;
use Storage;



class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ContentsIndex', 'UserSearchMap', 'ContentsIndexMap', 'likedMapList');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function ContentsIndex(Request $request)
    {
        $user_id = $request->id;

        $user = User::find($request->id);
        $follows = $user->getFollows($user_id);
        $followers = $user->getFollowers($user_id);

        $user = json_decode(json_encode($user), true);

        $content = Content::where('user_id',$user_id)->get();
        $content = json_decode(json_encode($content), true);


        $content = array_map(function($v){
        return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'lat' => $v['lat'],
                'lng' => $v['lng'],
            ];
        }, $content);
        $content = array_reverse($content);

        return view('user.index' ,['content' => $content,'user' => $user, 'follows'=> $follows, 'followers' => $followers]);
    }

    public function ContentsIndexMap(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);

        $follows = $user->getFollows($user_id);
        $followers = $user->getFollowers($user_id);

        $user = json_decode(json_encode($user), true);

        $content = Content::where('user_id',$user_id)->get();
        $content = json_decode(json_encode($content), true);


        $content = array_map(function($v){
            return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'lat' => $v['lat'],
                'lng' => $v['lng'],
            ];
        }, $content);

        return view('user.indexmap' ,['content' => $content,'user' => $user, 'follows'=> $follows, 'followers' => $followers]);
    }

    public function likedContent(Request $request)
    {
        $user_id = $request->id;

        $likedContent = Like::where('user_id', $user_id)->pluck('content_id');
        $likedContent = json_decode(json_encode($likedContent), true);

        $likedContent = array_map(function($v){

            return [
                    'id' => $v,
                    'img' => self::getPhotos($v),
                    'lat' => self::getLat($v),
                    'lng' => self::getLng($v),
            ];
        }, $likedContent);
        $likedContent = array_reverse($likedContent);

        $user = User::find($user_id);

        $user = json_decode(json_encode($user), true);


        return view('user.liked', ['content' => $likedContent, 'user' => $user]);

    }


    public function likedContentMap(Request $request)
    {
        $user_id = $request->id;

        $likedContent = Like::where('user_id', $user_id)->pluck('content_id');
        $likedContent = json_decode(json_encode($likedContent), true);

        $likedContent = array_map(function($v){

            return [
                    'id' => $v,
                    'img' => self::getPhotos($v),
                    'lat' => self::getLat($v),
                    'lng' => self::getLng($v),
            ];
        }, $likedContent);


        $user = User::find($user_id);

        $follows = $user->getFollows($user_id);
        $followers = $user->getFollowers($user_id);

        $user = json_decode(json_encode($user), true);


        return view('user.likedMap', ['content' => $likedContent, 'user' => $user, 'follows'=> $follows, 'followers' => $followers]);

    }

    public function likedMapList(Request $request)
    {
        $user_id = $request->user_id;
        // $content = Content::where('user_id', $user_id)->get();
        $likedContent = Like::where('user_id', $user_id)->pluck('content_id');
        $likedContent = json_decode(json_encode($likedContent), true);

        $likedContent = array_map(function($v){

            return [
                    'id' => $v,
                    'lat' => self::getLat($v),
                    'lng' => self::getLng($v),
            ];
        }, $likedContent);


        return $likedContent;
    }

    public function UserSearchMap(Request $request)
    {
        $user_id = $request->user_id;
        $content = Content::where('user_id', $user_id)->get();


        return $content;
    }

    public function edit(Request $request)
    {
        $user_id = $request->id;

        $user = User::find($user_id);
        $user = json_decode(json_encode($user), true);

        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $this->validate($request,User::$rules);
        $user_id = $request->id;

        User::find($user_id)->fill(['name' => $request->name, 'email' => $request->email ,'comment' => $request->comment])->save();

        return redirect('/user/'.$user_id.'/edit')->with('success', '更新しました。');
    }

    public function updateimg(Request $request)
    {
        $this->validate($request,User::$rule_img);

        $user_id = $request->id;

        if ($request->file('avatar_name')->isValid([])) {
            $filename = $request->file('avatar_name');

            $path = Storage::disk('s3')->putFile('user', $filename, 'public');
            $url = Storage::disk('s3')->url($path);

            $user = User::find(auth()->id());
            $user->avatar_name = basename($url);
            $user->save();

            return redirect('/user/'.$user_id.'/edit')->with('success', '更新しました。');
        } else {
            // return redirect()->back()->withInput()->withErrors(['file' => '画像がアップロードされていないか不正なデータです。'])->with('success', '保存しました。');
            return redirect()->back()->withInput()->with('fail', '画像がアップロードされていないか不正なデータです。');
        }

    }

    public function deleteimg(Request $request)
    {
        User::find($request->id)->fill(['avatar_name' => ''])->save();

        return redirect('/user/'.$request->id.'/edit')->with('success', '更新しました。');
    }


    public function follow(Request $request)
    {
        $follower = auth()->user();
        $user_id = $request->id;
        $user = User::where('id', $user_id)->get();
        $user = $user[0];

        if ($follower->id == $user_id) {
            return back();
        }
        if(!$follower->isFollowing($user_id)) {
            $follower->follow($user_id);

            // sending a notification
            $user->notify(new UserFollowed($follower));
            // $follower->notify(new UserFollowed($follower));

            return back();
        }
        return back();
    }

    public function unfollow(Request $request)
    {
        $follower = auth()->user();
        $user_id = $request->id;

        if($follower->isFollowing($user_id)) {
            $follower->unfollow($user_id);
            return back();
        }
        return back();
    }

    public function followlist(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($request->id);
        // 自分がフォローしている人
        $follows = $user->getFollows($user_id);
        // var_dump($follows->toArray());

        $follows = array_map(function($v){
            return [
                'id' => $v['follows_id'],
                'name' => self::getUserName($v['follows_id']),
                'comment' => self::getUserComment($v['follows_id']),
                'avatar_name' => self::getUserAvatar($v['follows_id']),
            ];

        },$follows->toArray());

        return view('user.followlist' ,['follow'=> $follows]);
    }

    public function followerlist(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);

        $followers = $user->getFollowers($user_id);

        $followers = array_map(function($v){
            return [
                'id' => $v['user_id'],
                'name' => self::getUserName($v['user_id']),
                'comment' => self::getUserComment($v['user_id']),
                'avatar_name' => self::getUserAvatar($v['user_id']),
            ];

        },$followers->toArray());

        return view('user.followlist' ,['follow'=> $followers]);
    }

    public function notifications()
    {
        $notifications =  auth()->user()->Notifications;

        return view('layouts.notifications', ['notifications' => $notifications]);
    }

    // functions
    public function getPhotos($contentid)
    {
        $photo = Photo::all()->where('content_id',$contentid);
        $path = $photo->pluck('path')->toArray();

        return $path;
    }

    public function getLat($contentid)
    {
        $lat = Content::where('id',$contentid)->pluck('lat')->toArray();
        $lat = $lat[0];

        return $lat;
    }

    public function getLng($contentid)
    {
        $lng = Content::where('id',$contentid)->pluck('lng')->toArray();
        $lng = $lng[0];

        return $lng;
    }



    public function getUserName($userId)
    {
        $photo = User::where('id',$userId);
        $path = $photo->pluck('name')->toArray();
        $path = $path[0];

        return $path;
    }

    public function getUserComment($userId)
    {
        $photo = User::where('id',$userId);
        $path = $photo->pluck('comment')->toArray();
        $path = $path[0];

        return $path;
    }

    public function getUserAvatar($userId)
    {
        $photo = User::where('id',$userId);
        $path = $photo->pluck('avatar_name')->toArray();
        $path = $path[0];

        return $path;
    }
}
