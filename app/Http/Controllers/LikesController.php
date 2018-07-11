<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Auth;
use App\Content;
use App\Notifications\UserLiked;
use App\User;

class LikesController extends Controller
{
    public function store(Request $request)
    {
		  $like = Like::create(['user_id' => $request->userid,'content_id' => $request->contentid]);
      $likeid = $like->id;

      $user_id = $request->contentuserid;
      $user = User::where('id', $user_id)->get();
      $user = $user[0];
      // // send notification
      $user->notify(new UserLiked($like));

      $content = Content::findOrFail($request->contentid);
      $likes_count = $content['likes_count'];


      // return $likes_count;
       return response()->json(['likes_count' => $likes_count, 'likeid' => $likeid]);
    }

    public function delete(Request $request)
    {
		  $content = Content::findOrFail($request->contentid);
	    $content->like_by($request->userid)->findOrFail($request->likeid)->delete();

		  $likes_count = $content['likes_count'];

      return $likes_count;

    }
}
