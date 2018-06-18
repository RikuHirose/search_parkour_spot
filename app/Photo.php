<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Content;


class Photo extends Model
{
	public $table = "photos";

    protected $fillable = ['content_id','path'];

    public function content()
    {
    	return $this->belongsTo('App\Content');
    }

}
