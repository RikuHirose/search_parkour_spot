<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
	protected $fillable = ['provider_id','provider']; //登録できる項目を宣言

    function User()
    {
    	return $this->belongsTo(User::class);
    }
}
