<?php

namespace App\Repositories;


use App\Question;
use App\Tag;

/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
  {
      return Question::create($attributes);
  }

    /**
     * @param array $tags
     * @return array
     */
    public function normalizeTag(array $tags)
  {
      return collect($tags)->map(function ($tag) {
          if (is_numeric($tag)) {
              Tag::find($tag)->increment('questions_count');
              return (int)$tag;
          }
          $newTag = Tag::create(['name' => $tag, 'questions_count' => 1]);

          return $newTag->id;
      })->toArray();
  }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function byIdWithTags($id)
  {
      return Question::with('tags')->findOrFail($id);
  }

    /**
     * 通过id删除问题
     * @param $id
     * @return mixed
     */
    public function byIdDelete($id)
  {
      return Question::findOrFail($id)->delete();
  }
}