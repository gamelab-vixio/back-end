<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    public function storyCategory(){
    	return $this->hasMany(StoryCategory::class, 'category_type_id');
    }

    public function categoryGenre(){
    	return $this->belongsTo(CategoryGenre::class, 'genre_id');
    }
}
