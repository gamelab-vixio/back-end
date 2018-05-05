<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryComment extends Model
{
    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function story(){
    	return $this->belongsTo(Story::class, 'story_id');
    }

    public function reply(){
        return $this->hasMany(StoryComment::class, 'comment_parent_id');
    }
}
