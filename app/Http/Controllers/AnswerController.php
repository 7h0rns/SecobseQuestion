<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
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
                'user_id' => $user->id
            ]);
            $user = User::find(Auth::user()->id)->increment('answers_count');
            $answer->question()->increment('answertimes');
            flash('回答成功', 'success');
        }

        return redirect('/questions/' . $question_id);
    }

    public function edit($id)
    {
        $answers =  Answer::findOrFail($id);

        if (Auth::user()->ownAnswer($answers)) {
            return view('questions.editAnswer',compact('answers'));
        }

        return back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $answers = Answer::find($id);

        $answers->update([
            'answer_content' => $request->get('answer_content'),
            'html_content' => Markdown::convertToHtml($request->get('answer_content')),
        ]);


        flash('回答修改成功!', 'success');

        return redirect()->route('questions.show', [$answers->question_id]);
    }

    public function adopt($id)
    {
        $answers = Answer::find($id);
        $question = Question::where('id',$answers->question_id);
        $adopt = $question->value('isadopt');
        if($adopt == 1)
        {
            flash('只能采纳一个问题作为最佳答案。','warning');
            return back();
        }
        else{
            $answers->isadopt = 1;

            $answers->save();

            $question->update(['isadopt' => 1]);

            return redirect()->route('questions.show', [$answers->question_id]);
        }

    }

    public function undoAdopt($id)
    {
        $answers = Answer::find($id);

        $answers->isadopt = 0;

        Question::where('id',$answers->question_id)->update(['isadopt' => 0]);

        $answers->save();

        return redirect()->route('questions.show', [$answers->question_id]);
    }
}
