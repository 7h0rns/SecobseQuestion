@extends('layouts.app')

@section('title', 'Tag|Questions')

@section('css')
<link rel="stylesheet" href="/css/other/questions.css">
@endsection

@section('content')
<div class="container">
	<div class="row">
		@if(Session::has('status'))
			<div class="alert alert-success">
				<button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ Session::get('status') }}
			</div>
		@endif

		<div class="col-md-9">
			<blockquote>标签: <span class="label label-success">{{ $tag->name }}</span></blockquote>
			@foreach($questions as $article)
				<div class="question-tags">
					<div class="count-wide">
							<div><p>-1</p><p>得票</p></div>
							<div><p>{{ $article->answertimes }}</p><p>回答</p></div>
							<div><p>{{ $article->readtimes }}</p><p>浏览</p></div>
					</div>
					<div class="count-narrow">
							<div><label for="vote" class="label label-default">得票: 0</label></div>
							<div><label for="answer" class="label label-default">回答: {{ $article->answertimes }}</label></div>
							<div><label for="view" class="label label-default">浏览: {{ $article->readtimes }}</label></div>
					</div>
					<div class="details">
						<div>
								<a href="{{ url('questions', $article->id) }}">
										<span>{{ $article->title }}</span>
								</a>
						</div>
						<div class="tag-and-create-info">
								@unless($article->tags->isEmpty())
										@foreach ($article->tags as $tag)
												<a href="{{url('tag/'.$tag->id.'')}}" class="tag">
														<label class="label label-success">{{ $tag->name }}</label>
												</a>
										@endforeach
								@endunless
								<div class="create-info">
										<a href="/profile/{{ $article->username }}">
												<span>{{ $article->username }}</span>
										</a>
										<span>{{ $article->created_at }}提问</span>
								</div>
						</div>
					</div>
				</div>
			@endforeach
			<nav class="page">
				{{$questions->render()}}
			</nav>
		</div>

		<div class="col-md-3">
			@if(Session::has('error'))
				<div class="alert alert-success">{{ Session::get('error') }}</div>
			@endif
			<div class="question-amount">
				<p>10</p>
				<p>问题标记</p>
				<a href="{{url('tag/'.$tag->id.'')}}">
						<label class="label label-success">{{ $tag->name }}</label>
				</a>
			</div>
			<div class="related-tags">
				<h4>相关标签</h4>
				<div class="tags-list">
					<div class="tags">
						<a href="#">JavaScript</a></a>
						<span>&nbsp;x&nbsp;1234</span>
					</div>
					<div class="tags">
						<a href="#">Vue</a>
						<span>&nbsp;x&nbsp;123</span>
					</div>
					<div class="tags">
						<a href="#">Vue-Router</a>
						<span>&nbsp;x&nbsp;12</span>
					</div>
					<div class="tags">
						<a href="#">原型与原型链</a>
						<span>&nbsp;x&nbsp;1</span>
					</div>
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
$(document).ready(function() {
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });

    var count = $(".count-wide");
    var greenOrRed = count.each(function(index, object) {
      for (var i = 0; i < 3; i++)
        helper(i, object);
    });
});

var helper = function(index, object) {

  var d = $($($(object).children()[index]));
  var content = $(d.children()[0]).text();

  if (content > 0)
    d.css("color", "green");
  if (content < 0)
    d.css("color", "red");
};
</script>
@endsection
