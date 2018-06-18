<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;


class Content extends Model
{

    protected $table = 'contents';

    protected $fillable = ['lat', 'lng', 'address', 'spot_name','rating'];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public static $rules = array(
            // 'file' => [
            //     // 必須
            //     'required',
            //     // アップロードされたファイルであること
            //     'file',
            //     // 最小縦横120px 最大縦横400px
            //     'dimensions:min_width=120,min_height=120,max_width=2000,max_height=2000',
            // ],
            'files.*.photo' => 'required|file|image|mimes:jpeg,bmp,png',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',
            'spot_name' => 'required',
            'rating' => [
                'required',
                'integer',
                'between:1,5'
            ],
     );
}
