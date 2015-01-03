<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Comment extends Eloquent {
    public function user()
    {
        return $this->belongsTo('User');
    }

    public function photo()
    {
        return $this->belongsTo('Photo');
    }
}
