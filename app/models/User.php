<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    protected $guarded = ['password', 'remember_token'];

	protected $hidden = ['password', 'remember_token'];

    public function getPhotos()
    {
        return $this->hasMany('Photo', 'user');
    }

    public function getFollowers()
    {
        return $this->belongsToMany('User', 'follows', 'to', 'from')->withTimestamps();
    }

    public function getFollowing()
    {
        return $this->belongsToMany('User', 'follows', 'from', 'to')->withTimestamps();
    }

    public function getLikes()
    {
        return $this->belongsToMany('Photo', 'likes', 'user', 'photo');
    }

}
