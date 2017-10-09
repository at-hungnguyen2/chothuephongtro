<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BeforeUpdate;

class Post extends Model
{
    use BeforeUpdate;
    
	CONST ITEMS_PER_PAGE = 10;
    CONST STATUS_READY = 1;
    CONST STATUS_NOTREADY = 0;
    CONST NOT_ACTIVE = 0;
    CONST ACTIVE = 1;
	
    protected $fillable = [
    	'user_id', 'post_type_id', 'cost_id', 'subject_id', 'district_id', 'street_id', 'title', 'image', 'content', 'address', 'lat', 'lng', 'status', 'is_active'
    ];

    public function comments()
    {
    	return $this->hasMany('App\Comment', 'post_id', 'id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function district()
    {
    	return $this->belongsTo('App\District', 'district_id', 'id');
    }

    public function cost()
    {
    	return $this->belongsTo('App\Cost', 'cost_id', 'id');
    }

    public function subject()
    {
    	return $this->belongsTo('App\Subject', 'subject_id', 'id');
    }

    public function postType()
    {
        return $this->belongsTo('App\PostType', 'post_type_id', 'id');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room', 'post_id', 'id');
    }
}
