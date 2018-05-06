<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function storyCategory(){
    	return $this->hasMany(StoryCategory::class, 'story_id');
    }

    public function storyReview(){
    	return $this->hasMany(StoryReview::class, 'story_id');
    }

    public function storyComment(){
    	return $this->hasMany(StoryComment::class, 'story_id');
    }

    public function reportedStory(){
        return $this->hasMany(StoryReport::class, 'story_id');
    }

    public function storyPlayed(){
        return $this->hasMany(StoryPlayed::class, 'story_id');
    }
}
