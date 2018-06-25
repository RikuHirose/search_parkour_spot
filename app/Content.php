<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;
use App\Tag;


class Content extends Model
{

    protected $table = 'contents';

    protected $fillable = ['lat', 'lng', 'address', 'spot_name', 'comment'];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    public static $rules = array(
            'files' => 'required',
            'files.*.photo' => 'required|file|mimes:jpeg,bmp,png,mp4,qt,x-ms-wmv,mpeg,x-msvideo|max:10000',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required|max:255',
            'spot_name' => 'required|max:255',
            'comment' => 'required|max:255',
     );

}
