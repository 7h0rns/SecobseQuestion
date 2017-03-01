@extends('layouts.app')

@section('title', 'Home')

@section('css')
<link rel="stylesheet" href="{{ asset('css/other/home.css') }}">
@endsection('css')

@section('content')
<div class="container">
   <div class="row">
     <div class="col-md-2">
        <ul class="nav flex-column navTab" role="tablist">
          <li class="nav-item active">
            <a class="nav-link active" href="#firstPage" data-toggle="tab" role="tab">
              我的信息
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#secondPage" data-toggle="tab" role="tab">
              <span class="leftarea">我的问题</span>
              <span class="badge">{{ $questionCount }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#thirdPage" data-toggle="tab" role="tab">
              <span class="leftarea">我的标签</span>
              <span class="badge">{{$tagsCount}}</span>
            </a>
          </li>
        </ul>
     </div>
     <div class="tab-content">
       <div class="col-md-10 active tab-pane" id="firstPage" role="tabpanel">
         <div class="panel panel-default">
           <div class="panel-heading">
             <h3 class="panel-title"> 我的信息</h3>
           </div>
           <div class="panel-body">
             <div class="col-md-6">
               <form class="form" action="/profile" method="POST" enctype="multipart/form-data">
                     @foreach($user as $u)
                     <img class="userImage" src="/uploads/avatars/{{ $u->avatar }}" alt="{{ $u->avatar }}" title="preview-img" />
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
             <div class="col-md-6">
              <h2>
                {{ $u->name }} 's Home
              </h2>
              <p>
                <span class="displayInfor">
                  <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                  @if($u->email)
                  {{$u->email}}&nbsp;
                  @else
                  no email&nbsp;
                  @endif
                  <span class="addEdit"><i class="fa fa-pencil  editColor">编辑</i></span>
                </span>
                <div class="addInfor">
                  <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="text" class="input-sm tagsInput form-control mr10 fillText" name="email"><button type="button" class="btn btn-sm btn-primary saveBtn" name="save">save</button>
                </div>
              </p>
             </div>
           </div>
           <div class="panel-footer firstFooter">
             上次登录时间: {{ Auth::user()->updated_at }}
             <span>
               <i class="fa fa-pencil" aria-hidden="true"></i>: 编辑
               <i class="fa fa-trash" aria-hidden="true"></i>: 删除
             </span>
           </div>
         </div>
       </div>
       <div class="col-md-10 tab-pane" id="secondPage" role="tabpanel">
         <div class="panel panel-default">
             <div class="panel-heading secondHead">
                 我的问题
                 <span><a href="/questions/create"><button class="btn btn-sm btn-success">提问</button></a></span>
             </div>

             <!-- List group -->
            <ul class="list-group">
              @foreach($userQuestions as $userQuestion)
              <li class="list-group-item listProblem">
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
            </ul>

          <div class="panel-footer secondFooter">
            <ul class="pager">
              <li class="previous"><a href="{{ $userQuestions->previousPageUrl() }}">上一页</a></li>
              <li class="next"><a href="{{ $userQuestions->nextPageUrl() }}">下一页</a></li>
            </ul>
          </div>
         </div>
       </div>
       <div class="col-md-10 tab-pane" id="thirdPage" role="tabpanel">
         <div class="panel panel-default">
             <div class="panel-heading">我的标签</div>
             <div class="panel-body">
                 @if($tags->isEmpty())
                     你还没有标签!
                     @else
                     <div>标签: <i class="fa fa-tags" aria-hidden="true"></i>
                         @foreach($tags as $tag)
                            <a href="{{url('tag/'.$tag->id.'')}}"> <span class="label label-success">{{ $tag->name }}&nbsp;</span></a>
                         @endforeach
                     </div>
                 @endif
             </div>
         </div>
       </div>
     </div>
   </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" scr="/js/jquery-2.2.3.js"></script>
    <script type="text/javascript" src="/js/home.js"></script>
    <script type="text/javascript">
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
