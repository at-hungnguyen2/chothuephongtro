<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	CONST ITEMS_PER_PAGE = 10;
	
    protected $fillable = [
    	'user_id', 'post_type_id', 'cost_id', 'subject_id', 'district_id', 'title', 'image', 'content', 'address', 'lat', 'lng'
    ];

    public function comments()
    {
    	return $this->hasMany('App\Comment', 'post_id', 'id');
    }
}
