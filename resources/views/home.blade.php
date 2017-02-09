@extends('layouts.app')

@section('title', 'Home')

@section('css')
<link rel="stylesheet" href="{{ asset('css/other/home.css') }}">
@endsection('css')

@section('content')
<div class="container">
    <div class="row">
      @if(Session::has('status'))
  				<div class="alert alert-success">
  						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
  						{{ Session::get('status') }}
  				</div>
  		@endif
        <div class="col-md-12 dashboard">
            <div class="panel panel-success">
                <div class="panel-heading">
                    控制面板
                </div>
                
                <div class="row detail-info">
                  <div class="col-md-4">
                    
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        个人信息
                      </div>
                      <div class="panel-body">
                          <form class="form" action="/profile" method="POST" enctype="multipart/form-data">
                              @foreach($user as $u)
                              <img class="userImage" src="/uploads/avatars/{{ $u->avatar }}" alt="{{ $u->avatar }}"/>
                              @endforeach
                              <div class="avatarButtons">
                                <label class="btn btn-sm btn-success btn-file">更新头像<input type="file" name="avatar"></label>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" value="提交" class="btn btn-sm btn-primary">
                              </div>
                          </form>
                          <hr>
                          <h5>
                            问题总数
                            <label for="count" class="label label-info">
                              {{ $questionCount }}
                            </label>
                          </h5>
                      </div>
                  </div>

                  </div>

                  <div class="col-md-4">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            我的问题
                            <span><a href="/questions/create"><button class="btn btn-sm btn-success">提问</button></a></span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach($userQuestions as $userQuestion)
                                <li class="list-group-item">
                                    <span class="badge" style="background-color: white;">
                                        <a href="#" class="pull-right deleteQuestion"
                                          data-id="{{ $userQuestion->id }}">
                                            <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                        </a>
                                        <a href="/questions/{{ $userQuestion->id }}/edit" class="pull-right"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a>
                                    </span>
                                    <a href="/questions/{{ $userQuestion->id }}">{{ $userQuestion->title }}</a>
                                </li>
                                @endforeach
                                <nav>
                                  <ul class="pager">
                                    <li class="previous"><a href="{{ $userQuestions->previousPageUrl() }}">上一页</a></li>
                                    <li class="next"><a href="{{ $userQuestions->nextPageUrl() }}">下一页</a></li>
                                  </ul>
                                </nav>
                            </ul>
                        </div>
                    </div>

                  </div>

                  <div class="col-md-4">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">我的标签</div>
                        <div class="panel-body">
                            @if($tags->isEmpty())
                                你还没有标签!
                                @else
                                <div>标签: <i class="fa fa-tags" aria-hidden="true"></i>
                                    @foreach($tags as $tag)
                                        <a href="{{url('tag/'.$tag->id.'')}}">{{ $tag->name }}&nbsp;</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                  </div>
                </div>

                <div class="panel-footer dashboard-footer">
                  上次登录时间: {{ Auth::user()->updated_at }}
                  <span>
                    <i class="fa fa-pencil" aria-hidden="true"></i>: 修改
                    <i class="fa fa-trash" aria-hidden="true"></i>: 删除
                  </span>
                </div>
            </div>
        </div>
  </div> 
</div>
@endsection

@section('js')
<script>
  $(document).ready(function() {
    $(".deleteQuestion").click(function() {
        var id = $(this).data("id");
        var self = $(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
          url: "/questions/" + id,
          type: "DELETE",
        }).done(function() {
          self.closest("li").remove();
        });
    });
  });
</script>
@endsection
