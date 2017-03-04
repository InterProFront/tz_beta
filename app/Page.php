<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected static $unguarded = true;

    public function threads()
    {
        return $this->hasMany('App\Thread', 'page_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'page_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function pageviews()
    {
        return $this->hasMany('App\Pageview', 'page_id');
    }

}
