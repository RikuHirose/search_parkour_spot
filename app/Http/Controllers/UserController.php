<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\Tag;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ContentsIndex', 'UserSearchMap', 'ContentsIndexMap');
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

        return view('user.index' ,['content' => $content,'user' => $user]);
    }

    public function ContentsIndexMap(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
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

        return view('user.indexmap', ['content' => $content, 'user' => $user]);
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
            $filename = $request->file('avatar_name')->store('/user');

            $user = User::find(auth()->id());
            $user->avatar_name = basename($filename);
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

    // functions
    public function getPhotos($contentid)
    {
        $photo = Photo::all()->where('content_id',$contentid);
        $path = $photo->pluck('path')->toArray();

        return $path;
    }
}
