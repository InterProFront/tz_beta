<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected static $unguarded = true;

    public function project()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
