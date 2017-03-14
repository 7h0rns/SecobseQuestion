@extends('layouts.app')

@section('title',  $post->title )

@section('css')
<link rel="stylesheet" href="/css/other/posts.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
            <div class="panel panel-default showPosts">
                <div class="panel-heading">
                    <h3 class="posts-title">{{ $post->title }}</h3>
                    <span class="posts-info">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <a href="{{ route('profile.name',[$post->username]) }}">{{ $post->username }}</a>
                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp; {{ $post->created_at }}
                        <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;{{ $post->read_count }}
                        <i class="fa fa-comments" aria-hidden="true"></i>&nbsp;{{ $post->comments_count }}
                    </span>
                </div>
                <div class="panel-body posts-body">
                    {!! $post->content !!}
                </div>
                <div id="debug"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
            <div class="panel panel-default comment">
                <div class="panel-heading">
                    <div class="comments">{{$post->comments->count('id')}}&nbsp;评论</div>
                </div>
                <div class="panel-body">
                <ul class="list-group row">
                @foreach($post->comments as $co)
                    <li class="list-group-item">
                    @MarkDown($co->html_content)
                    <img src="/uploads/avatars/{{ $co->user->avatar }}" alt="{{ $co->user->avatar }}"  style="border-radius: 50% ;width:32px;height: 32px"/>
                    <span class="username"><a href="/profile/{{ $co->username }}">{{ $co->username }}</a></span>
                    <span class="createdtime">&nbsp;·&nbsp;{{$co->created_at->diffForHumans()}}评论</span>

                    </li>
                @endforeach
                </ul>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
            <div class="addComment">
                <div class="comment-submit">
                    <form action="{{ route('comment.store') }}" method="post" class="form-group">
                        {{ csrf_field() }}
                        <input type="hidden" name="commentable_id" value="{{ $post->id }}">
                        <input type="hidden" name="id" value="{{$post->id}}">
                        <input type="hidden" name="commentable_type" value="App\Post">
                        <textarea name="content" rows="4" class="form-control" placeholder="填写评论,支持 Markdown 语法"
                        required></textarea>
                        <button type="submit" class="btn btn-success comment-btn">评论</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- scroll to top -->
<a href="#" class="scrollToTop"><i class="fa fa-angle-up fa-2x" aria-hidden="true"></i></a>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
});
</script>
@endsection
