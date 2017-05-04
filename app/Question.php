<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Auth;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    use SearchableTrait;

    protected $table = 'questions';

    protected $fillable = ['title', 'content', 'username'];

    protected $searchable = [
        'columns' => [
            'questions.title' => 10,
            'questions.content' => 5,
        ],
        'joins' => [

        ],
    ];

    /**
     * Scope a query find user questions.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserQuestions($query)
    {
        return $query->where('username', Auth::user()->name);
    }

    /**
     * Scope a query find user tags.
     *
     * @param $query
     * @return mixed
     */
    public function scopeUserTags($query)
    {
        $query = DB::table('questions')->join('question_tag', 'questions.id', '=', 'question_tag.question_id')
            ->join('tags', 'question_tag.tag_id', '=', 'tags.id')
            ->select('tags.name', 'tags.id')->where('questions.username', '=', Auth::user()->name);
        return $query;
    }

    /**
     * Restrict created_at time display format.
     *
     * @return \Carbon\Carbon
     */
    public function getCreatedAtAttribute($date)
    {
        if (Carbon::now() < Carbon::parse($date)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }

    /**
     * Question has many tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the answers for the question.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
