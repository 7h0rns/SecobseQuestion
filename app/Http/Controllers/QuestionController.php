<?php

namespace App\Http\Controllers;

use App\Answer;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Question;
use App\Tag;
use App\Vote;
use Illuminate\Support\Facades\DB;
use GrahamCampbell\Markdown\Facades\Markdown;

class QuestionController extends Controller
{
	/**
	 * Instantiate Questioncontroller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('show', 'index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('questions.createQuestion');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Requests\StoreQuestionRequest $request)
	{
	    $tags = $this->normalizeTag($request->get('tags'));
		$data = [
            'title' => $request->get('title'),
            'content' => $request->get('mdContent'),
            'username' => Auth::user()->name,
        ];

		$question = Question::create($data);

		$question->tags()->attach($tags);
        $user = User::find(Auth::user()->id)->increment('questions_count');

		flash('提问成功!', 'success');

		return redirect()->route('questions.show', [$question->id]);
	}

	/**
	 * Show single question and author.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$question =  Question::with('tags')->findOrFail($id);

		$question->readtimes += 1;

		$userAvatar = DB::table('users')->where('name',$question->username)->value('avatar');

		$answer = Answer::all()->where('question_id',$id);

		$question->save();

		$question->content = Markdown::convertToHtml($question->content);

		$popularQuestions = $question->orderBy('answertimes','desc')->where('answertimes','>',0)->limit(5)->get();
		return view('questions.show', compact('question','userAvatar','answer','popularQuestions'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$question =  Question::with('tags')->findOrFail($id);

		if (Auth::user()->owns($question)){
            return view('questions.edit', compact('question'));
        }

		return back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Requests\StoreQuestionRequest $request, $id)
	{
		$question = Question::with('tags')->findOrFail($id);
        $tags = $this->normalizeTag($request->get('tags'));

		$question->update([
            'title' => $request->get('title'),
            'content' => $request->get('mdContent')
        ]);

		$question->tags()->sync($tags);

        flash('问题更新成功!', 'success');

        return redirect()->route('questions.show', [$question->id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$question = Question::findOrFail($id);

		$question->delete();
	}

    /**
     * create new tag and increment questions_count
     *
     * @param array $tags
     * @return array
     */
    private function normalizeTag(array $tags)
    {
        return collect($tags)->map(function ($tag){
            if (is_numeric($tag)){
                Tag::find($tag)->increment('questions_count');
                return (int)$tag;
            }
            $newTag = Tag::create(['name' => $tag, 'questions_count' => 1]);

            return $newTag->id;
        })->toArray();
    }


}
