<?php

namespace App\Http\Controllers;

use App\Notifications\NewCommentNotification;
use App\Notifications\NewPostCommentNotification;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests;
use GrahamCampbell\Markdown\Facades\Markdown;
use Auth;

class CommentController extends Controller
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
            'content' => 'required',
        ]);

        $id = $request->get('id');
        $commentable_id = $request->get('commentable_id');
        $content = $request->get('content');

        if (Auth::user()) {
            $user = Auth::user();
        } else {
            flash('你还没有登录，请登录后再进行评论', 'warning');
            return redirect('/questions/' . $id);
        }

        $comment = Comment::create([
            'content' => $content,
            'html_content' => Markdown::convertToHtml($content),
            'commentable_id' => $commentable_id,
            'commentable_type' => $request->get('commentable_type'),
            'username' => $user->name,
            'user_id' => $user->id,
        ]);
        $user = User::find(Auth::user()->id)->increment('comments_count');

        flash('评论成功', 'success');
        if ($comment->commentable_type == 'App\Post') {
            $post = Post::find($id)->increment('comments_count');
            $comment->commentable->user->notify(new NewPostCommentNotification($comment));
            return redirect('posts/' . $id . '/#comment');
        }
        $comment->commentable->user->notify(new NewCommentNotification($comment));
        return redirect('/questions/' . $id);
    }

}
