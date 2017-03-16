<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Auth;
use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown;

class PostController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest('created_at')->Paginate(10);
        $hotPosts = Post::orderBy('read_count', 'desc')->Paginate(10);
        $popularUser = User::all()->sortByDesc('questions_count')->slice(0,5);
        return view('posts.postList', compact('posts','hotPosts','popularUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:6|max:196',
            'content' => 'required|min:26'
        ];
        $this->validate($request,$rules);
        $data = [
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'user_id' => Auth::id(),
            'username' => Auth::user()->name,
        ];

        $post = Post::create($data);

        flash('文章发布成功!', 'success');
        return redirect()->route('post.show',[$post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $post->increment('read_count');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =  Post::findOrFail($id);

        if (Auth::user()->owns($post)){
            return view('posts.edit', compact('post'));
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
        $post = Post::find($id);

        $post->update([
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);


        flash('文章更新成功!', 'success');

        return redirect()->route('post.show', [$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();
    }
}
