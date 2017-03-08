@extends('layouts.app')

@section('title', '个人信息')

@section('css')
<link rel="stylesheet" href="{{ asset('css/other/profile.css') }}">
@endsection('css')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 userInfor">
            @foreach($user as $u)
            <div class="single-member effect-3">
                <div class="member-image">
                    <img src="/uploads/avatars/{{ $u->avatar }}" alt="{{ $u->avatar }}" style="width:10em;height:10em;border-radius:0.9em"/>
                    @if ($u->isactive)
                    <label class="label label-success"><i class="fa fa-heart" aria-hidden="true"></i>在线</label>
                    @else
                    <label class="label label-danger"><i class="fa fa-heart-o" aria-hidden="true"></i>不在线</label>
                    @endif
                </div>

                <div class="member-info">
                    <h2>{{ $u->name }}</h2>
                    <h5><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;{{$u->email}}</h5>
                    <p>上次登录时间: {{ $u->updated_at }}</p>
                    <div class="social-touch">
                        @if($u->introduce)
                        <p>{{$u->introduce}}</p>
                        @else
                        该用户太懒什么也没留下
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#questions" role="tab" data-toggle="tab">我的问题</a></li>
                <li role="presentation"><a href="#posts" role="tab" data-toggle="tab">我的文章</a></li>
            </ul>

            <div class="tab-content posts-content">
                <div role="tabpanel" class="tab-pane active" id="questions">
                    <div class="panel panel-default" id="problemHead">
                        <!-- List group -->
                        <div class="list-group">
                            @foreach($questions as $question)
                            <a href="/questions/{{ $question->id }}" class="list-group-item">
                                <h3 class="list-group-item-heading" id="question-title">{{ $question->title }}</h3>
                                <p class="list-group-item-text">
                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                    @foreach ($question->tags as $tag)
                                    <label class="label label-success">{{ $tag->name }}</label>
                                    @endforeach
                                </p>
                            </a>
                            @endforeach
                        </div>

                        <nav class="page">
                            {{$questions->render()}}
                        </nav>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="posts">
                    <div class="panel panel-default" id="problemHead">
                        <!-- List group -->
                        <div class="list-group">
                            @foreach($userPosts as $userQuestion)
                            <a href="/posts/{{ $userQuestion->id }}" class="list-group-item">
                                <h3 class="list-group-item-heading" id="post-title">{{ $userQuestion->title }}</h3>
                            </a>
                            @endforeach
                        </div>

                        <nav class="page">
                            {{$userPosts->render()}}
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function() {
    var titles = $("h3#question-title");
    for (var i = 0; i < titles.length; i++) {
        var content = $(titles[i]).html();
        if (content.length > 20) {
            content = content.substring(0, 10) + "...";
        }
        $(titles[i]).html(content);
    }
});
</script>
@endsection
