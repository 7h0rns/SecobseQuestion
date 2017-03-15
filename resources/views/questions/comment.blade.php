@foreach($answer as $as)
    <div class="question-answers-mainbar">
        <div class="row question-answers">
            <div class="col-md-1 col-sm-1">
                <div class="answer-votes">
                    <user-vote-button answer="{{ $as->id }}" count="{{ $as->votes_count }}"></user-vote-button>
                </div>
                <div class="adopt">
                    @if($as->isadopt ==1)
                        <span class="adopt-icon"><i class="fa fa-check-square fa-2x" aria-hidden="true"></i></span>
                        <span class="adopt-text">已采纳</span>
                    @endif
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="answer-content">
                    <article id="answer_content">@MarkDown($as->html_content)</article>
                    <div class="answer-user-info">
                        <span class="answered-time">{{ $as->updated_at->diffForHumans() }}回答</span>
                        <img src="/uploads/avatars/{{ $as->avatar}}" alt="{{ $as->avatar}}"
                             style="border-radius: 50% ;width:32px;height: 32px"/>
                        <a href="/profile/{{ $as->answer_name }}">{{$as->answer_name}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="answer-comment">
            <div class="col-md-offset-1 col-sm-offset-1">
                <div class="comment">
                    <div class="operate">
                        <a class="comments">
                            &nbsp;评论{{$as->comments->count('id')}}
                        </a>
                        @if(Auth::check() && Auth::user()->ownAnswer($as))
                            <a href="/answer/{{$as->id}}/edit" class="editAnswer">编辑</a>
                        @endif
                        @if(Auth::check() && Auth::user()->owns($question))
                            @if($as->isadopt == 1)
                                <a href="{{ route('undoAdopt', [$as->id]) }}" class="adopt">取消采纳</a>
                            @else
                                <a href="{{ route('adopt', [$as->id]) }}" class="adopt">采纳该回答</a>
                            @endif
                        @endif
                        <span class="vote-btn"><user-vote-button answer="{{ $as->id }}" count="{{ $as->votes_count }}"></user-vote-button></span>
                    </div>
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
