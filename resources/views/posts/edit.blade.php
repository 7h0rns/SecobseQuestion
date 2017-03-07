@extends('layouts.app')

@section('title', '| 编辑文章')

@include('vendor.ueditor.assets')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 create-question">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑文章</div>
                    <div class="panel-body">
                        <form action="{{ route('posts.update',[$post->id]) }}" method="POST">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('title')?'has-error':'' }}">
                                <label for="title">标题</label>
                                <input id="title" type="text" class="form-control" name="title"
                                       value="{{ $post->title }}"
                                       autofocus>
                                @if ($errors->has('title'))
                                    <span class="help-block">
						                <strong>{{ $errors->first('title') }}</strong>
						            </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('content')?'has-error':'' }}">
                                <label for="content">内容</label>
                                <script id="container" name="content" style="height:300px" type="text/plain">
                                    {!! $post->content !!}
                                </script>
                                @if ($errors->has('content'))
                                    <span class="help-block">
						                <strong>{{ $errors->first('content') }}</strong>
						            </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success pull-right">发表文章</button>
                        </form>
                    </div>
                    <div id="debug"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        var ue = UE.getEditor('container',{
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

@endsection