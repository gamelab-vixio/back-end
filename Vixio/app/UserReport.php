<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    public function reporter(){
    	return $this->belongsTo(User::class, "reporter_user_id");
    }

    public function reported(){
    	return $this->belongsTo(User::class, "user_id");
    }

}
