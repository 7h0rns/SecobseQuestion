@extends('layouts.app')

@section('title',  $post->title )

@section('css')
    <link rel="stylesheet" href="/css/other/posts.css">
    <link rel="stylesheet" href="/css/share.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default showPosts">
                    <div class="panel-heading">
                        <h3 class="posts-title">{{ $post->title }}</h3>
                        <span class="posts-info">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <a href="{{ route('profile.name',[$post->username]) }}">{{ $post->username }}</a>
                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp; {{ $post->created_at }}
                            <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;{{ $post->read_count }}
                            <i class="fa fa-comments" aria-hidden="true"></i>&nbsp;{{ $post->comments_count }}
                    </span>
                    </div>
                    <div class="panel-body posts-body">
                        {!! $post->content !!}
                    </div>
                    <div class="panel-footer" style="background-color: white">
                        <div class="social-share" data-disabled="diandian,linkedin"
                             data-wechat-qrcode-title="请打开微信扫一扫"></div>
                    </div>
                    <div id="debug"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading postFollow">
                        <h2>{{ $post->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body">
                        {{--<a href="/post/{{$post->id}}/follow"--}}
                        {{--class="btn btn-default {{ Auth::user()->followed($post->id) ? 'btn-success':'' }}">--}}
                        {{--{{ Auth::user()->followed($post->id) ? '已关注':'关注该问题' }}--}}
                        {{--</a>--}}
                        <post-follow-button post="{{ $post->id }}"></post-follow-button>
                        <a href="#editor" class="btn btn-primary pull-right">撰写评论</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading postFollow">
                        <h5>关于作者</h5>
                    </div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="">
                                    <img width="36" src="/uploads/avatars/{{$post->user->avatar}}"
                                         alt="{{$post->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="">
                                        {{$post->user->name}}
                                    </a>
                                </h4>
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-3" style="text-align: center">
                                    <div class="static-text">问题</div>
                                    <div class="static-count">{{$post->user->questions_count}}</div>
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <div class="static-text">回答</div>
                                    <div class="static-count">{{$post->user->answers_count}}</div>
                                </div>
                                <div class="col-md-4" style="text-align: center">
                                    <div class="static-text">关注者</div>
                                    <div class="static-count">{{$post->user->followers_count}}</div>
                                </div>
                            </div>
                        </div>
                        <user-follow-button user="{{ $post->user_id }}"></user-follow-button>
                        <send-message user="{{ $post->user_id }}"></send-message>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default comment" id="comment">
                    <div class="panel-heading">
                        <div class="comments">{{$post->comments->count('id')}}&nbsp;评论</div>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group row">
                            @foreach($post->comments as $co)
                                <li class="list-group-item">
                                    @MarkDown($co->html_content)
                                    <img src="/uploads/avatars/{{ $co->user->avatar }}" alt="{{ $co->user->avatar }}"
                                         style="border-radius: 50% ;width:32px;height: 32px"/>
                                    <span class="username"><a
                                                href="/profile/{{ $co->username }}">{{ $co->username }}</a></span>
                                    <span class="createdtime">&nbsp;·&nbsp;{{$co->created_at->diffForHumans()}}评论</span>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="addComment">
                    <div class="comment-submit">
                        <form action="{{ route('comment.store') }}" method="post" class="form-group">
                            {{ csrf_field() }}
                            <input type="hidden" name="commentable_id" value="{{ $post->id }}">
                            <input type="hidden" name="id" value="{{$post->id}}">
                            <input type="hidden" name="commentable_type" value="App\Post">
                            <textarea name="content" rows="4" id="editor" class="form-control"
                                      placeholder="填写评论,支持 Markdown 语法"
                                      required></textarea>
                            <button type="submit" class="btn btn-success comment-btn">评论</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- scroll to top -->
    <a href="#" class="scrollToTop"><i class="fa fa-angle-up fa-2x" aria-hidden="true"></i></a>
@endsection

@section('js')
    <script src="/js/social-share.min.js"></script>
    <script>
        $(document).ready(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.scrollToTop').fadeIn();
                } else {
                    $('.scrollToTop').fadeOut();
                }
            });
            $('.scrollToTop').click(function () {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });
        });
    </script>
@endsection
