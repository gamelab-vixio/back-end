<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{

	protected $fillable = ['reason', 'user_id', 'reporter_user_id', 'comment_type', 'image_url'];

    public function reporter(){
    	return $this->belongsTo(User::class, "reporter_user_id");
    }

    public function reported(){
    	return $this->belongsTo(User::class, "user_id");
    }

}
