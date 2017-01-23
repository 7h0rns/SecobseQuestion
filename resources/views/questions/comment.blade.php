@foreach($answer as $as)
<div class="row question-answers">
	<div class="col-md-1 col-sm-1">
		<div class="answer-votes">
			<a href="#" class="vote-top" data-toggle="tooltip" data-placement="top" title="This answer is useful"><i class="fa fa-caret-up fa-2x" aria-hidden="true"></i></a>
			<span class="vote-times">10</span>
			<a href="#" class="vote-bottom" data-toggle="tooltip" data-placement="bottom" title="This answer is not useful"><i class="fa fa-caret-down fa-2x" aria-hidden="true"></i></a>
		</div>
	</div>
	<div class="col-md-8 col-sm-8">
		<div class="answer-comment">
			<div class="answer-content">
				<article id="answer_content">@MarkDown($as->html_content)</article>
				<div class="answer-user-info">
					<span class="answered-time">answered&nbsp;{{ $as->created_at }}</span>
					<img src="/uploads/avatars/{{ $as->avatar}}" alt="{{ $as->avatar}}" width="32" height="32"/>
					<a href="/profile/{{ $as->answer_name }}">{{$as->answer_name}}</a>
				</div>
			</div>
			@foreach($as->comments as $co)
				<div class="comment-content">
					@MarkDown($co->html_content)
					<span>–{{ $co->username }}&nbsp;&nbsp;{{$co->created_at->diffForHumans()}}</span>
				</div>
			@endforeach
			<div class="comment">
				<div class="comments">add a comment(Total comments:{{$as->comments->count('id')}})</div>
				<div class="addComment" style="display: none">
					<form action="{{ route('comment.store') }}" method="post" class="form-horizontal">
						{{ csrf_field() }}
						<input type="hidden" name="commentable_id" value="{{ $as->id }}">
						<input type="hidden" name="id" value="{{$question->id}}">
						<input type="hidden" name="commentable_type" value="App\Answer">
						<textarea name="content" placeholder="填写评论" required></textarea>
						<button type="submit" class="btn btn-default">Comment</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
