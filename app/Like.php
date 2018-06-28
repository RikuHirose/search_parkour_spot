<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use kanazaca\CounterCache\CounterCache;

class Like extends Model
{
    use CounterCache;

    public $counterCacheOptions = [
    	'Content' => [
    		'field' => 'likes_count',
    		'foreignKey' => 'content_id'
    	]
    ];

    protected $fillable = [ 'user_id', 'content_id'];

    public function content()
    {
    	return $this->belongsTo('App\Content');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public static $rules = array(
    	'content_id' => 'required',
		'user_id' => 'required',
    );
}
