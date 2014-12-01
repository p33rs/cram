<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Photo extends Eloquent {
    public function user()
    {
        return $this->belongsToOne('User', 'user');
    }

    public function likers()
    {
        return $this->belongsToMany('User', 'likes', 'photo', 'user');
    }

    public function comments()
    {
        return $this->hasMany('Comment', 'photo');
    }
}
