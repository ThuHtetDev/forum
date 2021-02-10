@extends('layouts.app')
@section('content')
<div class="container">
   
    <div class="row">
        <div class="col-md-8" >
            @foreach($threads as $thread)
                <div class="card m-4">
                    <div class="card-header" style="display:flex;">
                        <a href="{{$thread->path()}}" style="flex:1;"><h3>{{$thread->title}}</h3></a>
                        <strong><a href="{{$thread->path()}}"> {{ $thread->replies->count() < 1 ? 'No '. \Str::plural('reply',$thread->replies->count()) : $thread->replies->count() .' '. \Str::plural('reply',$thread->replies->count())}}</a></strong>
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4" >
            <div class="list-group m-4">
                <a href="/threads" class="list-group-item list-group-item-action {{Request::segment(2) == '' ? 'active' : ''}}">
                   All
                </a>
                @foreach($channels as $channel)
                    <a href="/threads/{{$channel->slug}}" class="list-group-item list-group-item-action {{Request::segment(2) == $channel->slug ? 'active' : ''}}">{{$channel->name}}</a>
                @endforeach
                </div>
        </div>
    </div>
 
</div>
@endsection

