@extends('layouts.app')

@section('title')
    {{ $question->title }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/other/show.css') }}">
    <link href="{{ asset('css/simplemde.min.css') }}" rel="stylesheet">
@endsection('css')

@section('content')
    <div class="container">
        <div class="row">
            <div class="question-header">
                <span class="title">{{ $question->title }}</span>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="question-mainbar">
                    <div class="row">
                        <div class="col-md-1 col-sm-1">
                            <div class="question-vote">
                                <a href="#" class="vote-top" data-toggle="tooltip" data-placement="top"
                                   title="问题对人有帮助，内容完整，我也想知道答案"><i
                                            class="fa fa-caret-up fa-2x" aria-hidden="true"></i></a>
                                <span class="vote-times">1</span>
                                <a href="#" class="vote-bottom" data-toggle="tooltip" data-placement="bottom"
                                   title="问题没有实际价值，缺少关键内容，没有改进余地"><i
                                            class="fa fa-caret-down fa-2x" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <div class="question-content">
                                <article>
                                    @MarkDown($question->content)
                                </article>

                                <div class="tags">
                                    @unless($question->tags->isEmpty())
                                        @foreach($question->tags as $tag)
                                            <a href="{{url('tag/'.$tag->id.'')}}">{{ $tag->name }}</a>
                                        @endforeach
                                    @endunless
                                </div>

                                <div class="user-info">
                                    <span class="asked-time">{{ $question->created_at }}提问</span>
                                    <img src="/uploads/avatars/{{ $userAvatar }}" alt="{{ $userAvatar }}" width="32"
                                         height="32"/>
                                    <a href="/profile/{{ $question->username }}">{{ $question->username }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="answers">
                        <span>{{$count}}个回答</span>
                    </div>
                </div>

                @include('questions.comment')

                <div class="panel panel-default">
                  <div class="panel-heading"><h4>撰写回答:</h4></div>
                  <div class="panel-body">
                    <form id="answer" action="/answer" method="POST" class="form-horizontal">
                        <input type="hidden" name="question_id" id="question_id" value="{{ $question->id }}">
                        <textarea name="answer_content" id="answerEditor"></textarea>
                        {!! csrf_field() !!}
                        <button type="submit" id="tsave" class="btn btn-success pull-right">提交回答</button>
                    </form>
                  </div>
                </div>

                @if ($errors->has('mdContent'))
                    <span class="help-block">
				                <strong>{{ $errors->first('mdContent') }}</strong>
			                </span>
                @endif

            </div>

            <div class="col-md-3 col-sm-3">
                <div class="question-sidebar">
                    <div class="question-state">
                        <p>提问&nbsp;&nbsp;&nbsp;<span>{{ $question->created_at }}</span></p>
                        <p>得票&nbsp;&nbsp;&nbsp;<span>{{ $question->readtimes }}</span></p>
                        <p>回答&nbsp;&nbsp;&nbsp;<span>10</span></p>
                    </div>
                    <div class="related">
                        <h4>相关问题</h4>
                        <div class="related-list">
                            <div class="list-content">
                                <div class="answer-times">
                                    <span>10</span>
                                </div>
                                <a href="#">
                                    <span>You can try to make a meaningful question</span>
                                </a>
                            </div>
                            <div class="list-content">
                                <div class="answer-times">
                                    <span>10</span>
                                </div>
                                <a href="#">
                                    <span>You can try to make a meaningful question</span>
                                </a>
                            </div>
                            <div class="list-content">
                                <div class="answer-times">
                                    <span>10</span>
                                </div>
                                <a href="#">
                                    <span>You can try to make a meaningful question</span>
                                </a>
                            </div>
                            <div class="list-content">
                                <div class="answer-times">
                                    <span>10</span>
                                </div>
                                <a href="#">
                                    <span>You can try to make a meaningful question</span>
                                </a>
                            </div>
                            <div class="list-content">
                                <div class="answer-times">
                                    <span>10</span>
                                </div>
                                <a href="#">
                                    <span>You can try to make a meaningful question</span>
                                </a>
                            </div>
                            <div class="list-content">
                                <div class="answer-times">
                                    <span>10</span>
                                </div>
                                <a href="#">
                                    <span>You can try to make a meaningful question</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('js')
    <script src="/js/simplemde.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.comments').click(function () {
                $comment = $(this).closest('.comment');
                $comment.siblings().find('.addComment').slideUp();
                $comment.find('.addComment').fadeToggle(1000, 'swing');
            });

            var simplemde = new SimpleMDE({
                element: $("#answerEditor")[0],
                codeSyntaxHighlighting: true

            });
        });
    </script>
@endsection
