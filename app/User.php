<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\SocialProvider;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_name', 'remember_token', 'comment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function contents()
    {
        return $this->hasMany('App/Content');
    }

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public static $rules = array(
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'comment' => '|present|max:255',
    );

    public static $rule_img =array(
        'avatar_name' => 'required|file|mimes:jpeg,bmp,png|max:1000',
    );
}
