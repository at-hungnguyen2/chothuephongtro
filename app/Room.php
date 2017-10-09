<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BeforeUpdate;

class Room extends Model
{
    use BeforeUpdate;
    
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
