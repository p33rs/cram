<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Comment extends Eloquent {
    public function getUser()
    {
        return $this->belongsToOne('User', 'user');
    }

    public function getPhoto()
    {
        return $this->belongsToOne('Photo', 'photo');
    }
}
