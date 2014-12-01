<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Comment extends Eloquent {
    public function user()
    {
        return $this->belongsToOne('User', 'user');
    }

    public function photo()
    {
        return $this->belongsToOne('Photo', 'photo');
    }
}
