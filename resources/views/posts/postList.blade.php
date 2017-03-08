@extends('layouts.app')

@section('title', '文章')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">文章列表</div>
                    <div class="panel-body">
                        <ul class="list-group">
                        @foreach($posts as $post)
                            <li class="list-group-item">
                            <a href="{{ route('post.show',[$post->id]) }}">{{ $post->title }}</a>
                            <i class="fa fa-user"></i><a href="{{ route('profile.name',[$post->username]) }}">{{ $post->username }}</a>发布于{{ $post->created_at }}
                            </li>
                        @endforeach
                        </ul>
                    </div>
                    <div id="debug"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel-body">
                    <p>今天，有什么开发相关的分享呢？</p>
                    <p><a class="btn btn-success btn-block" href="/posts/create" role="button">撰写</a></p>
                    <p>开始吧!</p>
                </div>
            </div>
        </div>
    </div>

@endsection


