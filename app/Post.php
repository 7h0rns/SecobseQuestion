<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id','username'];

    public function getCreatedAtAttribute($date)
    {
        if (Carbon::now() < Carbon::parse($date)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }

    /**
     * Scope a query find user questions.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserPosts($query)
    {
        return $query->where('username', Auth::user()->name);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * posts has many comment
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}
