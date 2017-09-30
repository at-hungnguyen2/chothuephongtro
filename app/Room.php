<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
    	'amount', 'image', 'cost_id', 'post_id', 'subject_id', 'status'
    ];

    public function cost()
    {
    	return $this->belongsTo('App\Cost', 'cost_id', 'id');
    }

    public function subject()
    {
    	return $this->belongsTo('App\Subject', 'subject_id', 'id');
    }

    public function post()
    {
    	return $this->belongsTo('App\Post', 'post_id', 'id');
    }
}
