<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Auth;
use App\Content;

class LikesController extends Controller
{
    public function store(Request $request)
    {
		$like = Like::create(['user_id' => $request->userid,'content_id' => $request->contentid]);

        $content = Content::findOrFail($request->contentid);
		$likes_count = $content['likes_count'];


       	// return $likes_count;
       	return response()->json(['likes_count' => $likes_count, 'likeid' => $like->id]);
    }

    public function delete(Request $request)
    {
		  $content = Content::findOrFail($request->contentid);
	    $content->like_by($request->userid)->findOrFail($request->likeid)->delete();

		  $likes_count = $content['likes_count'];

      return $likes_count;

    }
}
