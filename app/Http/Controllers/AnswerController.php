<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use GrahamCampbell\Markdown\Facades\Markdown;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'answer_content' => 'required'
        ]);

        $question_id = $request->get('question_id');
        $content = $request->input('answer_content');
        if (Auth::user()) {
            $user = Auth::user();
        } else {
            flash('你还没有登录，请登录后再进行回答', 'warning');
            return redirect('/questions/' . $question_id);
        }

        $query = \DB::table('answers')->select('answer_name')
            ->where('question_id', $question_id)
            ->where('answer_name', $user->name)
            ->get()->all();

        if ($query) {
            flash('你已经回答了', 'danger');
        } else {
            $answer = Answer::create([

                'answer_name' => $user->name,
                'answer_content' => $content,
                'html_content' => Markdown::convertToHtml($content),
                'avatar' => $user->avatar,
                'question_id' => $question_id,

            ]);

            flash('回答成功', 'success');
        }

        return redirect('/questions/' . $question_id);
    }
}
