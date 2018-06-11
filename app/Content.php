<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Content extends Model
{

    protected $table = 'contents';

    protected $fillable = ['icon_name', 'lat', 'lng', 'address', 'spot_name'];

    public static $rules = array(
            'file' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 最小縦横120px 最大縦横400px
                'dimensions:min_width=120,min_height=120,max_width=1000,max_height=1000',
            ],
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',
            'spot_name' => 'required',
     );

     public static $edit = array(
            'file' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 最小縦横120px 最大縦横400px
                'dimensions:min_width=120,min_height=120,max_width=1000,max_height=1000',
            ],
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',
            'spot_name' => 'required',
     );
}
