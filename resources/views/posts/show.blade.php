@extends('layouts.app')

@section('title',  $post->title )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 create-question">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $post->title }}
                        <i class="fa fa-user"></i><a href="{{ route('profile.name',[$post->username]) }}">{{ $post->username }}</a>发布于{{ $post->created_at }}
                    </div>
                    <div class="panel-body">
                      {!! $post->content !!}
                    </div>
                    <div id="debug"></div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .panel-body img{
            width: 100%;
        }
    </style>
@endsection

