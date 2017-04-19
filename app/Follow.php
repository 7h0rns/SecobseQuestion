<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'user_post';

    protected $fillable = ['user_id', 'post_id'];
}
