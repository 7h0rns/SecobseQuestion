@foreach($answer as $as)
<div class="question-answers-mainbar">
  <div class="row question-answers">
      <div class="col-md-1 col-sm-1">
          <div class="answer-votes">
              {{--<a href="#" class="vote-top" data-toggle="tooltip" data-placement="top" title="答案对人有帮助，有参考价值"><i--}}
                          {{--class="fa fa-caret-up fa-2x" aria-hidden="true"></i></a>--}}
              {{--<span class="vote-times">10</span>--}}
              {{--<a href="#" class="vote-bottom" data-toggle="tooltip" data-placement="bottom"--}}
                 {{--title="答案没帮助，是错误的答案，答非所问"><i class="fa fa-caret-down fa-2x" aria-hidden="true"></i></a>--}}
                 <user-vote-button answer="{{ $as->id }}" count="{{ $as->votes_count }}"></user-vote-button>
          </div>
      </div>
      <div class="col-md-8 col-sm-8">
        <div class="answer-content">
            <article id="answer_content">@MarkDown($as->html_content)</article>
            <div class="answer-user-info">
                <span class="answered-time">{{ $as->created_at }}回答</span>
                <img src="/uploads/avatars/{{ $as->avatar}}" alt="{{ $as->avatar}}" width="32" height="32"/>
                <a href="/profile/{{ $as->answer_name }}">{{$as->answer_name}}</a>
            </div>
        </div>
      </div>
  </div>
  <div class="answer-comment">
    <div class="col-md-offset-1 col-sm-offset-1">
      <div class="comment">
          <div class="comments">{{$as->comments->count('id')}}评论</div>
          <div class="addComment">
                @foreach($as->comments as $co)
                    <div class="comment-content">
                        @MarkDown($co->html_content)
                        <span class="username"><a href="/profile/{{ $as->answer_name }}">{{ $co->username }}</a></span>
                        <span class="createdtime">&nbsp;·&nbsp;{{$co->created_at->diffForHumans()}}</span>
                    </div>
                @endforeach
                <div class="comment-submit">
                  <form action="{{ route('comment.store') }}" method="post" class="form-horizontal">
                      {{ csrf_field() }}
                      <input type="hidden" name="commentable_id" value="{{ $as->id }}">
                      <input type="hidden" name="id" value="{{$question->id}}">
                      <input type="hidden" name="commentable_type" value="App\Answer">
                      <div class="input-group">
                        <textarea name="content" rows="1" class="form-control" placeholder="填写评论,支持 Markdown 语法"
                                  required></textarea>
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-success">评论</button>
                        </span>
                      </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endforeach
