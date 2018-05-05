<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function blog(){
    	return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function reply(){
        return $this->hasMany(BlogComment::class, 'comment_parent_id');
    }
}
