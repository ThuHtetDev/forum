@extends('layouts.app')
@section('content')
<div class="container">
   
    <div class="row">
        <div class="col-md-8" >
            @forelse($threads as $thread)
                <div class="card m-4">
                    <div class="card-header" style="display:flex;">
                        @if(\Auth::check() && $thread->hasVisitedFor())
                            <a href="{{$thread->path()}}" style="flex:1;">
                                <h3>{{$thread->title}}
                                    <i class="fa fa-circle"  style="color: #3490DC; font-size:8px;" aria-hidden="true"></i>
                                </h3>
                            </a>
                        @else
                            <a href="{{$thread->path()}}" style="flex:1;"><h3>{{$thread->title}}</h3></a>
                        @endif
                      
                        <strong>
                        <a href="{{$thread->path()}}"> 
                            {{ $thread->replies->count() < 1 ? 'No '. \Str::plural('reply',$thread->replies->count()) : $thread->replies->count() .' '. \Str::plural('reply',$thread->replies->count())}}
                            <i class="fa fa-comments" aria-hidden="true"></i>
                        </a>
                        </strong>
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            @empty
                <div>There is no threads till now. Be the first one:</div>
            @endforelse
        </div>
        <div class="col-md-4">
            @if(!\Request()->has('by'))
                <div class="list-group m-4">
                    <a href="/threads" class="list-group-item list-group-item-action {{Request::segment(2) == '' ? 'active' : ''}}">
                    All
                    </a>
                    @foreach($channels as $channel)
                        <a href="/threads/{{$channel->slug}}" class="list-group-item list-group-item-action {{Request::segment(2) == $channel->slug ? 'active' : ''}}">{{$channel->name}}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
 
</div>
@endsection

