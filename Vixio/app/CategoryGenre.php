<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryGenre extends Model
{
    public function categoryType(){
    	return $this->hasMany(CategoryType::class, 'genre_id');
    }
}
