<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    protected $guarded = ['password', 'remember_token'];

	protected $hidden = ['password', 'remember_token'];

    public function getFullname() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function photos()
    {
        return $this->hasMany('Photo');
    }

    public function followers()
    {
        return $this->belongsToMany('User', 'follows', 'to', 'from')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany('User', 'follows', 'from', 'to')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany('Photo', 'likes');
    }

}
