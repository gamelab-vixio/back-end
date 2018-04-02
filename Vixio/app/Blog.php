<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	//admin?
	
    public function blogComment(){
    	return $this->hasMany(BlogComment::class, 'blog_id');
    }
}
