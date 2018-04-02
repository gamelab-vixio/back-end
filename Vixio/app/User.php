<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function story(){
        return $this->hasMany(Story::class, 'user_id');
    }

    public function userReporter(){
        return $this->hasMany(UserReport::class, 'reporter_user_id');
    }

    public function reportedUser(){
        return $this->hasMany(UserReport::class, 'user_id');
    }

    public function storyReporter(){
        return $this->hasMany(StoryReport::class, 'reporter_user_id');
    }

    public function blogComment(){
        return $this->hasMany(BlogComment::class, 'user_id');
    }

    public function storyComment(){
        return $this->hasMany(StoryComment::class, 'user_id');
    }

    public function storyReview(){
        return $this->hasMany(StoryReview::class, 'user_id');
    }
}
