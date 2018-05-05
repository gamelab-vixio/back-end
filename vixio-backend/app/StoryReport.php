<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryReport extends Model
{

	protected $fillable = ['reason', 'story_id', 'reporter_user_id', 'image_url'];

    public function reporter(){
    	return $this->belongsTo(User::class, 'reporter_user_id');
    }

    public function reported(){
    	return $this->belongsTo(Story::class, "story_id");
    }
}
