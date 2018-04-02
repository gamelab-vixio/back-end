<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryReport extends Model
{
    public function reporter(){
    	return $this->belongsTo(User::class, 'reporter_user_id');
    }

    public function reported(){
    	return $this->belongsTo(Story::class, "story_id");
    }
}
