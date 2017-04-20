<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;
    use CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirmation_token','api_token','introduce'
    ];

     /**
     * The attributes that are primarykey.
     *
     * @var array
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Judge whether the questioner
     * @param Model $model
     * @return bool
     */
    public function owns(Model $model)
    {
        return $this->name == $model->username;
    }

    public function follows()
    {
       return $this->belongsToMany(Post::class,'user_post')->withTimestamps();
    }

    public function followThis($post)
    {
        return $this->follows()->toggle($post);
    }

    public function followed($post)
    {
        return !! $this->follows()->where('post_id',$post)->count();
    }

    public function followers(){
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')
            ->withTimestamps();
    }

    public function followersUser(){
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')
            ->withTimestamps();
    }

    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Question', "username", "name");
    }

    public function ownAnswer(Model $model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, "user_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class,"username", "name");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
	{
		return $this->hasMany('App\Tag');
	}

    /**
     * Get the answers for the question.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    /**
     * return answer_id Boolean(!!)
     * @param $answer
     * @return bool
     */
    public function hasVotedFor($answer)
    {
        return !! $this->votes()->where('answer_id',$answer)->count();
    }
}

