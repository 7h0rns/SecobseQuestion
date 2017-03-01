@extends('layouts.app')

@section('title', '个人信息')

@section('css')
<link rel="stylesheet" href="{{ asset('css/other/profile.css') }}">
@endsection('css')

@section('content')
<div class="container">
    <div class="row profile">
      <div class="col-md-6">
      @foreach($user as $u)
        <div class="single-member effect-3">
          <div class="member-image">
            <img src="/uploads/avatars/{{ $u->avatar }}" alt="{{ $u->avatar }}" style="width:100px;height:100px;"/>
          </div>
          <div class="member-info">
            <h2>{{ $u->name }}</h2>
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;{{$u->email}}</h5>
            <p>描述信息...</p>
            <div class="social-touch">
              <a class="fb-touch" href="#"><i class="fa fa-2x fa-github" aria-hidden="true"></i><a href="https://github.com/happylwp"></a></a>
            </div>
          </div>
        </div>
      </div>
			<div class="col-md-6">
         <div class="panel panel-success">
            <!-- Default panel contents -->
            <div class="panel-heading">我的问题</div>

            <!-- List group -->
            <ul class="list-group">
                <li class="list-group-item">
                    @foreach($questions as $question)
        						<a href="/questions/{{ $question->id }}" class="list-group-item">
        						  <h3 class="list-group-item-heading" id="question-title">{{ $question->title }}</h3>
        						  <p class="list-group-item-text">
        						  	  <i class="fa fa-tag" aria-hidden="true"></i>
        						  	  @foreach ($question->tags as $tag)
        						  		  <span>{{ $tag->name }}</span>
        						  	  @endforeach
        						  </p>
        						</a>
    					      @endforeach
                  </li>
                  <li class="list-group-item">Cras justo odio</li>
                  <li class="list-group-item">Dapibus ac facilisis in</li>
                  <li class="list-group-item">Morbi leo risus</li>
                  <li class="list-group-item">Porta ac consectetur ac</li>
                  <li class="list-group-item">Vestibulum at eros</li>
              </ul>
              <div class="panel-footer">
                <ul class="pager">
      				    <li class="previous"><a href="{{ $questions->previousPageUrl() }}">上一页</a></li>
      				    <li class="next"><a href="{{ $questions->nextPageUrl() }}">下一页</a></li>
      				  </ul>
              </div>
          </div>
			</div>

        @endforeach
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
