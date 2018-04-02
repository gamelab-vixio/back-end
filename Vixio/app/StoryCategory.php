<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryCategory extends Model
{
    public function story(){
    	return $this->belongsTo(Story::class, 'story_id');
    }

    public function categoryType(){
    	return $this->belongsTo(CategoryType::class, 'category_type_id');
    }
}
