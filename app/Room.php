<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{   
    const ITEMS_PER_PAGE = 10;
    CONST STATUS_READY = 1;
    CONST STATUS_NOTREADY = 0;

    protected $fillable = [
    	'amount', 'image', 'cost', 'post_id', 'subject_id', 'status'
    ];

    public function subject()
    {
    	return $this->belongsTo('App\Subject', 'subject_id', 'id');
    }

    public function post()
    {
    	return $this->belongsTo('App\Post', 'post_id', 'id');
    }
}
