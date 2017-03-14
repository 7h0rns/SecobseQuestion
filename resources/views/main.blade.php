@extends('layouts.app')

@section('title', 'Secobse')

@section('css')
    <link rel="stylesheet" href="/css/other/main.css">
@endsection

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#recent" role="tab" data-toggle="tab">最新的</a></li>
                    <li role="presentation"><a href="#noanswer" role="tab" data-toggle="tab">未回答的</a></li>
                    <li role="presentation"><a href="#mostviewed" role="tab" data-toggle="tab">热门的</a></li>
                </ul>

                {{--rencentQuestions--}}
                <div class="tab-content question-content">
                    <div role="tabpanel" class="tab-pane active" id="recent">
                        @foreach($questions as $question)
                            <div class="singleQuestion">
                                <div class="count-wide">
                                    <div><p>{{ $question->answertimes }}</p>
                                        <p>回答</p></div>
                                    <div><p>{{ $question->readtimes }}</p>
                                        <p>浏览</p></div>
                                </div>
                                <div class="details">
                                    <div>
                                        <a href="{{ url('questions', $question->id) }}">
                                            <span>{{ $question->title }}</span>
                                        </a>
                                    </div>
                                    <div class="tag-and-create-info">
                                        @unless($question->tags->isEmpty())
                                            @foreach ($question->tags as $tag)
                                                <a href="{{url('tag/'.$tag->id.'')}}" class="tag">
                                                    <label class="label label-success">{{ $tag->name }}</label>
                                                </a>
                                            @endforeach
                                        @endunless
                                        <div class="create-info">
                                            <a href="/profile/{{ $question->username }}">
                                                <span>{{ $question->username }}</span>
                                            </a>
                                            <span class="spanColor">{{ $question->created_at }}提问</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="count-narrow">
                                    <div><label for="answer"
                                                class="label label-default">回答: {{ $question->answertimes }}</label>
                                    </div>
                                    <div><label for="view"
                                                class="label label-default">浏览: {{ $question->readtimes }}</label></div>
                                </div>
                            </div>
                        @endforeach
                        @if($questions->count('id') >= 15)
                            <nav class="page">
                                {{ $questions->links() }}
                            </nav>
                        @endif
                    </div>

                    {{--noAnswerQuestions--}}
                    <div role="tabpanel" class="tab-pane" id="noanswer">
                        @foreach($noAnswerQuestion as $question)
                            <div class="singleQuestion">
                                <div class="count-wide">
                                    <div><p>{{ $question->answertimes }}</p>
                                        <p>回答</p></div>
                                    <div><p>{{ $question->readtimes }}</p>
                                        <p>浏览</p></div>
                                </div>
                                <div class="details">
                                    <div>
                                        <a href="{{ url('questions', $question->id) }}">
                                            <span>{{ $question->title }}</span>
                                        </a>
                                    </div>
                                    <div class="tag-and-create-info">
                                        @unless($question->tags->isEmpty())
                                            @foreach ($question->tags as $tag)
                                                <a href="{{url('tag/'.$tag->id.'')}}" class="tag">
                                                    <label class="label label-success">{{ $tag->name }}</label>
                                                </a>
                                            @endforeach
                                        @endunless
                                        <div class="create-info">
                                            <a href="/profile/{{ $question->username }}">
                                                <span>{{ $question->username }}</span>
                                            </a>
                                            <span class="spanColor">{{ $question->created_at }}提问</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="count-narrow">
                                    <div><label for="answer"
                                                class="label label-default">回答: {{ $question->answertimes }}</label>
                                    </div>
                                    <div><label for="view"
                                                class="label label-default">浏览: {{ $question->readtimes }}</label></div>
                                </div>
                            </div>
                        @endforeach
                        @if($noAnswerQuestion->count('id') >= 15)
                            <nav class="page">
                                {{ $noAnswerQuestion->links() }}
                            </nav>
                        @endif
                    </div>

                    {{--mostViewQuestions--}}
                    <div role="tabpanel" class="tab-pane" id="mostviewed">

                        @foreach($mostViewQuestion as $question)
                            <div class="singleQuestion">
                                <div class="count-wide">
                                    <div><p>{{ $question->answertimes }}</p>
                                        <p>回答</p></div>
                                    <div><p>{{ $question->readtimes }}</p>
                                        <p>浏览</p></div>
                                </div>
                                <div class="details">
                                    <div>
                                        <a href="{{ url('questions', $question->id) }}">
                                            <span>{{ $question->title }}</span>
                                        </a>
                                    </div>
                                    <div class="tag-and-create-info">
                                        @unless($question->tags->isEmpty())
                                            @foreach ($question->tags as $tag)
                                                <a href="{{url('tag/'.$tag->id.'')}}" class="tag">
                                                    <label class="label label-success">{{ $tag->name }}</label>
                                                </a>
                                            @endforeach
                                        @endunless
                                        <div class="create-info">
                                            <a href="/profile/{{ $question->username }}">
                                                <span>{{ $question->username }}</span>
                                            </a>
                                            <span class="spanColor">{{ $question->created_at }}提问</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="count-narrow">
                                    <div><label for="answer"
                                                class="label label-default">回答: {{ $question->answertimes }}</label>
                                    </div>
                                    <div><label for="view"
                                                class="label label-default">浏览: {{ $question->readtimes }}</label></div>
                                </div>
                            </div>
                        @endforeach
                        @if($mostViewQuestion->count('id') >= 15)
                            <nav class="page">
                                {{ $mostViewQuestion->links() }}
                            </nav>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="questions-create">
                    <p>今天，你编程遇到了什么问题呢？</p>
                    <p><a class="btn btn-success btn-block" href="/questions/create" role="button">提问</a></p>
                    <p>开始吧!</p>
                </div>
                <div class="list-group recommend">
                    <h4 class="recommend-name">活跃用户</h4>
                    <ol>
                        @foreach($popularUser as $hotUser)
                            <li>
                                <img src="/uploads/avatars/{{ $hotUser->avatar }}"/>
                                <a href="/profile/{{ $hotUser->name }}">{{ $hotUser->name }}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(Session::has('error'))
            <div class="alert alert-success">{{ Session::get('error') }}</div>
        @endif
        <footer>
            <!-- footer content -->
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            　　<h3>Find us on github</h3>
                            <ul>
                                <li><a href="https://github.com/G1enY0ung">G1enY0ung</a></li>
                                <li><a href="https://github.com/Gasbylei">Gasbylei</a></li>
                                <li><a href="https://github.com/happylwp">happylwp</a></li>
                                <li><a href="https://github.com/loner11">loner11</a></li>
                                <li><a href="https://github.com/Th0rns">Th0rns</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer bottom -->
            <div class="footer-bottom">
                <div class="container">
                    <p class=""> Copyright &copy; Secobse. 2016 All right reserved. </p>
                </div>
            </div>
        </footer>
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

            console.log(content);

            if (content > 0)
                d.css("color", "green");
            if (content < 0)
                d.css("color", "red");
        };
    </script>
@endsection
