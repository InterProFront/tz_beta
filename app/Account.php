<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    protected static $unguarded = true;

    public function projects()
    {
        return $this->hasMany('App\Project', 'account_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }
}
