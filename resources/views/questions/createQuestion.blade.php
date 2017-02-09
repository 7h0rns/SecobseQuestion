@extends('layouts.app')

@section('title', '提问')

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
                    <div class="panel-heading">发布问题</div>
                    <div class="panel-body">
                        <form action="/questions" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input id="title" type="text" class="form-control" name="title"
                                       value="{{ old('title') }}"
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
                                    <select class="form-control" multiple="multiple" name="tags[]" id="task-list">
                                        @foreach($tags as $id=>$name)
                                            <option id="tag" value="{{ $id }}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tags'))
                                        <div class="alert alert-danger">
                                            <strong>{{ $errors->first('tags') }}</strong>
                                        </div>
                                    @endif
                                    <span class="input-group-btn">
								        <button type="button" class="btn btn-success" id="add">添加标签</button>
							        </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mdContent">描述</label>
                                <textarea name="mdContent" id="ID"></textarea>
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
    </div>
    {{--Modal--}}
    @include('tags.createtag')
@endsection

@section('js')
    <script src="/js/simplemde.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <link href="http://cdn.bootcss.com/toastr.js/2.1.3/toastr.min.css" rel="stylesheet">
    <script src="http://cdn.bootcss.com/toastr.js/2.1.3/toastr.min.js"></script>
    <script src="/	js/tag.js"></script>
    <script type="text/javascript">
        $("select").select2({
            tokenSeparators: [",", " "],
            maximumSelectionLength: 5,
            placeholder: "选择标签",
            theme: "bootstrap"
        });
    </script>
    <script>
        var simplemde = new SimpleMDE({
            element: $("#ID")[0]
        });
    </script>


@endsection
