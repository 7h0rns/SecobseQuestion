@extends('layouts.app')

@section('title', '文章')

@section('css')
<link rel="stylesheet" href="/css/other/posts.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#recent" role="tab" data-toggle="tab">最新的</a></li>
                <li role="presentation"><a href="#mostviewed" role="tab" data-toggle="tab">热门的</a></li>
            </ul>

            <div class="tab-content posts-content">
                <div role="tabpanel" class="tab-pane active" id="recent">
                    @foreach($posts as $post)
                    <div class="singlePosts">
                        <div class="count-wide">
                            <div><p>{{$post->comments->count('id')}}</p><p>评论</p></div>
                        </div>
                        <div class="details">
                            <div>
                                <a href="{{ route('post.show',[$post->id]) }}">
                                    <span>{{ $post->title }}</span>
                                </a>
                            </div>
                            <div class="create-info">
                                <a href="{{ route('profile.name',[$post->username]) }}">
                                    <span>{{ $post->username }}</span>
                                </a>
                                <span class="spanColor">{{ $post->created_at }}发布</span>
                            </div>
                        </div>
                        <div class="count-narrow">
                            <div><label for="vote" class="label label-default">评论: {{$post->comments->count('id')}}</label></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div role="tabpanel" class="tab-pane" id="mostviewed">
                    @foreach($hotPosts as $post)
                    <div class="singlePosts">
                        <div class="count-wide">
                            <div><p>{{$post->comments->count('id')}}</p><p>评论</p></div>
                        </div>
                        <div class="details">
                            <div>
                                <a href="{{ route('post.show',[$post->id]) }}">
                                    <span>{{ $post->title }}</span>
                                </a>
                            </div>
                            <div class="create-info">
                                <a href="{{ route('profile.name',[$post->username]) }}">
                                    <span>{{ $post->username }}</span>
                                </a>
                                <span class="spanColor">{{ $post->created_at }}发布</span>
                            </div>
                        </div>
                        <div class="count-narrow">
                            <div><label for="vote" class="label label-default">评论: {{$post->comments->count('id')}}</label></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="posts-create">
                <p>今天，有什么开发相关的分享呢？</p>
                <p><a class="btn btn-success btn-block" href="/posts/create" role="button">撰写</a></p>
                <p>开始吧!</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function() {
    var count = $(".count-wide");
    var greenOrRed = count.each(function(index, object) {
      for (var i = 0; i < 3; i++)
        helper(i, object);
    });
});

var helper = function(index, object) {

  var d = $($($(object).children()[index]));
  var content = $(d.children()[0]).text();

  console.log(content);

  if (content > 0)
    d.css("color", "green");
  if (content < 0)
    d.css("color", "red");
};
</script>
@endsection
