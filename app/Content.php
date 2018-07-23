<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;
use App\Tag;
use App\User;
use App\Like;
use Auth;


class Content extends Model
{

    protected $table = 'contents';

    protected $fillable = ['lat', 'lng', 'address', 'spot_name', 'comment', 'user_id'];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function like_by($userid)
    {
        return Like::where('user_id', $userid)->first();
    }

    public function scopeTagFilter($query, ?string $tag)
    {
        if(strpos($tag,'#') !== false){
          //'tag'のなかに'#'が含まれている場合
            $tag = $tag;
        } elseif(strpos($tag,'#') == false) {
            $tag = '#'.$tag;
        }

        if (!is_null($tag)) {
            return $query->where('comment', 'like', '%' . $tag . '%');
        }
        return $query;
    }

    // public function scopeSearchAddress(?string $word)
    //  {
    //      if (!is_null($word)) {
    //          $content =  Content::where('address', 'like', '%' . $word . '%')->get();
    //      }
    //      return $content;

    // }

    public function scopeSearchSpotName($query, ?string $word)
    {
        if (!is_null($word)) {
            return $query->where('spot_name', 'like', '%' . $word . '%');
        }
        return $query;
    }

    public static $rules = array(
            'files' => 'required',
            'files.*.photo' => 'required|file|mimes:jpeg,bmp,png,mp4,qt,x-ms-wmv,mpeg,x-msvideo|max:10000',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required|max:255',
            'spot_name' => 'required|max:50',
            'comment' => 'required|max:255',
            'user_id' => 'required',
     );

}
