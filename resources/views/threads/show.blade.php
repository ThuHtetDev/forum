
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row m-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$thread->title}}</div>
                <div class="card-body">
                    {{$thread->body}}
                </div>
                <div class="card-footer">Posted by <a href="#">{{$thread->creator->name}}</a> </div>
            </div>
                <ul class="m-5">
                    @foreach($replies as $reply)
                        @include('threads.reply')
                    @endforeach
                    {{$replies->links()}}
                </ul>
                @if(\Auth::check())
                    <div class="row justify-content-center m-5">
                        <form action="{{$thread->path().'/replies'}}" method="POST">
                            @csrf 
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <textarea name="reply" class="form-control" id="" rows="10" cols="60" placeholder="How Do You Think?.." required>{{ old('body') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Reply Comment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    Please <a href="{{route('login')}}">Signin</a> to post this reply.
                @endif
        </div>

        <div class="col-md-4 bg-default">
            <div class="list-group">
                <span class="list-group-item list-group-item-action active">
                    Thread Info
                </span>
                <span class="list-group-item list-group-item-action"> Published By <a href="#">{{$thread->creator->name}}</a></span>
                <span class="list-group-item list-group-item-action"> Published at {{$thread->created_at->diffForHumans()}}</span>
                <span class="list-group-item list-group-item-action"> {{$thread->replies->count()}} {{ \Str::plural('reply',$thread->replies->count()) }} to this thread</span>
            </div>
        <div>
    </div>

   
</div>
@endsection