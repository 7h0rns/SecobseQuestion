<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
{
    use SearchableTrait;

    protected $fillable = ['title', 'content', 'user_id','username'];

    protected $searchable = [
        'columns' => [
            'posts.title' => 10,
            'posts.content' => 5,
        ],
    ];

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
