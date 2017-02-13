<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = ['name','bio','questions_count'];

	/**
	 * Tags has many questions
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function questions()
	{
		return $this->belongsToMany(Question::class)->withTimestamps();
	}
}
