@extends('layouts.app')

@section('title', 'Search')

@section('css')
    <link rel="stylesheet" href="/css/other/questions.css">
    <style>
        a span {
            color: #333;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <blockquote><i class="fa fa-search"></i> 关于 “<span class="highlight">{{ $q }}</span>” 的搜索结果,
                    共 {{ $count }} 条
                </blockquote>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#questions" role="tab"
                                                              data-toggle="tab">问题&nbsp;{{ $question_count }}</a>
                    </li>
                    <li role="presentation"><a href="#posts" role="tab" data-toggle="tab">文章&nbsp;{{ $post_count }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="questions">
                        @if($question_count == 0)
                            <div>
                                这里没有找到你要的内容。
                            </div>
                        @endif
                        @foreach($questions as $question)
                            <div class="question-tags">
                                <div class="count-wide">
                                    <div><p>{{ $question->answertimes }}</p>
                                        <p>回答</p></div>
                                    <div><p>{{ $question->readtimes }}</p>
                                        <p>浏览</p></div>
                                </div>
                                <div class="count-narrow">
                                    <div><label for="answer"
                                                class="label label-default">回答: {{ $question->answertimes }}</label>
                                    </div>
                                    <div><label for="view"
                                                class="label label-default">浏览: {{ $question->readtimes }}</label></div>
                                </div>
                                <div class="details">
                                    <div>
                                        <a href="{{ url('questions', $question->id) }}">
                                            <span>{{ $question->title }}</span>
                                        </a>
                                    </div>
                                    <div class="tag-and-create-info">
                                        @unless($question->tags->isEmpty())
                                            @foreach ($question->tags as $t)
                                                <a href="{{url('tag/'.$t->id.'')}}" class="tag">
                                                    <label class="label label-success">{{ $t->name }}</label>
                                                </a>
                                            @endforeach
                                        @endunless
                                        <div class="create-info">
                                            <a href="/profile/{{ $question->username }}">
                                                <span>{{ $question->username }}</span>
                                            </a>
                                            <span>{{ $question->created_at }}提问</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($questions)
                            <nav class="page">
                                {{$questions->links()}}
                            </nav>
                        @endif
                    </div>

                    <div role="tabpanel" class="tab-pane" id="posts">
                        @if($post_count == 0)
                            <div>
                                这里没有找到你要的内容。
                            </div>
                        @endif
                        @foreach($posts as $post)
                            <div class="question-tags">
                                <div class="count-wide">
                                    <div><p>{{$post->comments->count('id')}}</p>
                                        <p>评论</p></div>
                                    <div><p>{{ $post->read_count }}</p>
                                        <p>浏览</p></div>
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
                                    <div><label for="vote"
                                                class="label label-default">评论: {{$post->comments->count('id')}}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
        $(document).ready(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.scrollToTop').fadeIn();
                } else {
                    $('.scrollToTop').fadeOut();
                }
            });
            $('.scrollToTop').click(function () {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });

            var count = $(".count-wide");
            var greenOrRed = count.each(function (index, object) {
                for (var i = 0; i < 3; i++)
                    helper(i, object);
            });
        });

        var helper = function (index, object) {

            var d = $($($(object).children()[index]));
            var content = $(d.children()[0]).text();

            if (content > 0)
                d.css("color", "green");
            if (content < 0)
                d.css("color", "red");
        };
    </script>
@endsection
