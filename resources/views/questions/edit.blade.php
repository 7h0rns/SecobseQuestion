@extends('layouts.app')

@section('title', '| Edit your question')

@section('css')
    <link href="/css/simplemde.min.css" rel="stylesheet">
    <link href="/css/select2.min.css" rel="stylesheet"/>
    <link href="/css/select2-bootstrap.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 create-question">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑问题</div>
                    <div class="panel-body">
                        <form action="/questions/{{ $question->id  }}" method="POST">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('title')?'has-error':'' }}">
                                <label for="title">标题</label>
                                <input id="title" type="text" class="form-control" name="title"
                                       value="{{ $question->title }}"
                                       autofocus>
                                @if ($errors->has('title'))
                                    <span class="help-block">
						                <strong>{{ $errors->first('title') }}</strong>
						            </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tags">标签</label>
                                <div class="input-group">
                                    <select class="form-control" multiple="multiple" name="tags[]" id="task-list" style="width: 100%">
                                        @foreach($question->tags as $tag)
                                            <option value="{{ $tag->id }}" selected="selected">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tags'))
                                        <span class="help-block">
						                    <strong>{{ $errors->first('tags') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('mdContent')?'has-error':'' }}">
                                <label for="mdContent">描述</label>
                                <textarea name="mdContent" id="ID">{{ $question->content }}</textarea>
                                @if ($errors->has('mdContent'))
                                    <span class="help-block">
				                        <strong>{{ $errors->first('mdContent') }}</strong>
				                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success pull-right">发布问题</button>
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
    <script src="/js/select2.min.js"></script>
    <script type="text/javascript">
        function formatTag(tag) {
            return "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" +
            tag.name ? tag.name : "Laravel" +
                "</div></div></div>";
        }

        function formatTagSelection(tag) {
            return tag.name || tag.text;
        }

        $("select").select2({
            tags: true,
            minimumInputLength: 2,
            maximumSelectionLength: 5,
            placeholder: "选择标签",
            theme: "bootstrap",
            ajax: {
                url: '/api/tags',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            templateResult: formatTag,
            templateSelection: formatTagSelection,
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    </script>
    <script>
        var simplemde = new SimpleMDE({
            element: $("#ID")[0]
        });
    </script>
@endsection