@extends('layouts.app')

@section('title','消息通知')
<style>
    .notifications {
        position: relative;
        padding: 8px 15px 8px 25px;
        color: #666;
        border: none;
        border-top: 1px dotted #eee;
        background: transparent;
    }
    .notifications.unread {
        background: #fff9ea;
    }
</style>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">消息通知</div>
                    <div class="panel-body">
                        @foreach($user->notifications as $notification)
                            @include('notifications.'.snake_case(class_basename($notification->type)))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
