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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function ContentsIndex()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $content = Content::where('user_id',$user_id)->get();

        $user = json_decode(json_encode($user), true);
        $content = json_decode(json_encode($content), true);
        

        $content = array_map(function($v){
        return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'lat' => $v['lat'],
                'lng' => $v['lng'],
            ];
        }, $content);

        return view('user.index' ,['content' => $content,'user' => $user]);


    }

    // functions
    public function getPhotos($contentid)
    {
        $photo = Photo::all()->where('content_id',$contentid);
        $path = $photo->pluck('path')->toArray();

        return $path;
    }
}
