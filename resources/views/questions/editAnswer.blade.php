@extends('layouts.app')

@section('title', '| Edit your question')

@section('css')
    <link href="/css/simplemde.min.css" rel="stylesheet">
    <style>
        .btn {
            margin: 3px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 create-question">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑回答</div>
                    <div class="panel-body">
                        <form action="/answer/{{ $answers->id  }}" method="POST">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('answer_content')?'has-error':'' }}">
                                <label for="answer_content">你的回答:</label>
                                <textarea name="answer_content" id="ID">{{ $answers->answer_content }}</textarea>
                                @if ($errors->has('answer_content'))
                                    <span class="help-block">
				                        <strong>{{ $errors->first('answer_content') }}</strong>
				                    </span>
                                @endif
                            </div>
                            <a href="{{ url('questions', $answers->question_id) }}" class="btn btn-default pull-right">取消</a>
                            <input type="submit" class="btn btn-success pull-right" value="确认修改">
                        </form>
                    </div>
                    <div id="debug"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="/js/simplemde.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({
            element: $("#ID")[0]
        });
    </script>
@endsection