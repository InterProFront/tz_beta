<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected static $unguarded = true;

    public function comments()
    {
        return $this->hasMany('App\Comment', 'thread_id');
    }

    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}
