<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pageview extends Model
{
    protected static $unguarded = true;
    public $timestamps = false;

    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
