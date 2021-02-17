@extends('layouts.app')
@section('content')
<div class="container">
   
    <div class="row">
        <div class="col-md-8" >
            @include('threads.thread_lists')

            {{$threads->render()}}
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

