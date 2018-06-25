<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Content;

class Tag extends Model
{

	protected $table = 'tags';

    protected $fillable = ['tag_name'];

    public function contents()
    {
    	return $this->belongsToMany('App\Content')->withTimestamps();
    }
}
