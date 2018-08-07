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


    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follows_id', 'user_id')
                    ->withTimestamps();
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follows_id')
                    ->withTimestamps();
    }

     public function follow($userId)
    {
        $this->follows()->attach($userId);
        return $this;
    }

    public function unfollow($userId)
    {
        $this->follows()->detach($userId);
        return $this;
    }

    public function isFollowing($userId)
    {
        // return (boolean) $this->follows()->where('follows_id', $userId)->first(['id']);
        return (boolean) $this->follows()->where('follows_id', $userId)->first();
        // return (boolean) $this->follows()->where('follows_id', $userId)->get();
    }

    public function getFollows($userId)
    {
        return Follower::where('user_id', $userId)->get();
    }

    public function getFollowers($userId)
    {
        return Follower::where('follows_id', $userId)->get();
    }



    public static $rules = array(
        'name' => 'required|string|max:30',
        'email' => 'required|string|email|max:255',
        'comment' => '|present|max:255',
    );

    public static $rule_img =array(
        'avatar_name' => 'required|file|mimes:jpeg,bmp,png|max:1000',
    );
}
