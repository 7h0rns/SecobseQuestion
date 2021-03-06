@extends('layouts.app')

<style>
    .unread {
        background-color: #fff9ea;
    }
</style>
@section('title','私信列表')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信列表</div>
                    <div class="panel-body">
                        @foreach($messages as  $messageGroup)
                            <div class="media {{ $messageGroup->first()->shouldAddUnreadClass() ? 'unread' : '' }}">
                                <div class="media-left">
                                    <a href="#">
                                        @if(Auth::id() == $messageGroup->last()->from_user_id)
                                        <img src="/uploads/avatars/{{ $messageGroup->last()->toUser->avatar }}" alt="" width="40px">
                                        @else
                                            <img src="/uploads/avatars/{{ $messageGroup->last()->fromUser->avatar }}" alt="" width="40px">
                                        @endif
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        @if(Auth::id() == $messageGroup->last()->from_user_id)
                                        <a href="profile/{{ $messageGroup->last()->toUser->name }}">
                                            {{ $messageGroup->last()->toUser->name }}
                                        </a>
                                            @else
                                            <a href="profile/{{ $messageGroup->last()->fromUser->name }}">
                                                {{ $messageGroup->last()->fromUser->name }}
                                            </a>
                                            @endif
                                    </h4>
                                    <p>
                                        <a href="/inbox/{{ $messageGroup->first()->dialog_id }}">
                                            {{ $messageGroup->first()->body }}
                                        </a>
                                        <span class="pull-right">
                                            {{$messageGroup->first()->created_at->format('Y-m-d')}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
