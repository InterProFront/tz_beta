<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected static $unguarded = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany('App\User', 'members', 'project_id', 'user_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Page', 'project_id');
    }

    public function threads()
    {
        return $this->hasMany('App\Thread', 'project_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'project_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id');
    }
}
