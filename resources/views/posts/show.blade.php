@extends('layouts.app')

@section('title',  $post->title )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 create-question">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $post->title }}
                        <i class="fa fa-user"></i><a href="{{ route('profile.name',[$post->username]) }}">{{ $post->username }}</a>发布于{{ $post->created_at }}
                    </div>
                    <div class="panel-body">
                      {!! $post->content !!}
                    </div>
                    <div id="debug"></div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default comment">
            <div class="panel-heading">
            <div class="comments">{{$post->comments->count('id')}}评论</div>
            <div class="addComment">
                <div class="comment-submit">
                    <form action="{{ route('comment.store') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="commentable_id" value="{{ $post->id }}">
                        <input type="hidden" name="id" value="{{$post->id}}">
                        <input type="hidden" name="commentable_type" value="App\Post">
                        <div class="input-group">
                        <textarea name="content" rows="4" class="form-control" placeholder="填写评论,支持 Markdown 语法"
                                  required></textarea>
                            <span class="input-group-btn">
                          <button type="submit" class="btn btn-success">评论</button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
            </div>

            @foreach($post->comments as $co)
                <div class="comment-content panel-body">
                    @MarkDown($co->html_content)
                    <span class="username"><a href="/profile/{{ $co->username }}">{{ $co->username }}</a></span>
                    <span class="createdtime">&nbsp;·&nbsp;{{$co->created_at->diffForHumans()}}评论</span>
                    <hr>
                </div>
            @endforeach
        </div>
        </div>
        </div>
    </div>
    <style>
        .panel-body img{
            width: 100%;
        }
    </style>
@endsection

