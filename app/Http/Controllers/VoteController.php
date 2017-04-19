<?php

namespace App\Http\Controllers;

use App\User;
use App\Answer;
use App\Repositories\AnswerRepository;
use Auth;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    protected $answer;

    /**
     * VotesController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->middleware('auth');
        $this->answer = $answer;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function users($id)
    {
        $user = Auth::guard('api')->user();

        if($user->hasVotedFor($id)){
            return response()->json(['voted' => true]);
        }

        return response()->json(['voted' => false]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote()
    {
        $answer = $this->answer->byId(request('answer'));
        $voted = Auth::guard('api')->user()->voteFor(request('answer'));

        if (count($voted['attached'])>0) {
            $answer->increment('votes_count');

            return response()->json(['voted' => true]);
        }

        $answer->decrement('votes_count');

        return response()->json(['voted' => false]);

    }
}
