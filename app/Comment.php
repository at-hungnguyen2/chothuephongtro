<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	CONST ITEMS_PER_PAGE = 10;

	protected $fillable = [
		'user_id', 'post_id', 'comment'
	];

    public function post()
    {
    	return $this->belongsTo('App\Post', 'post_id', 'id');;
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getPostComments($postId)
    {
    	return $this->where('post_id', $postId)->paginate(self::ITEMS_PER_PAGE);
    }
}
