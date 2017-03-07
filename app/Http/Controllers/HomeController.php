<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Question;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$userQuestions = Question::userQuestions()->orderBy('published_at', 'desc')->Paginate(5);
        $userPosts = Post::userPosts()->orderBy('created_at', 'desc')->Paginate(5);
		$user = DB::table('users')
			->where('name',  Auth::user()->name)
			->get();
		$tags = Question::UserTags()->distinct()->get();
        $tagsCount = $tags->count();
        $questionCount = DB::table('questions')->where('username', Auth::user()->name)->count();
        $postCount = DB::table('posts')->where('username', Auth::user()->name)->count();
        return view('home', compact('userQuestions','tags','user', 'questionCount','tagsCount','userPosts','postCount'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'introduce' => 'required',
        ]);
        $user = User::find(Auth::user()->id);
        $user->introduce = $request->get('introduce');
        $user->save();
        return $user;
    }
}
