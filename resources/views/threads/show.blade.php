
@extends('layouts.app')
@section('content')

@section('header-css')
    <link href="{{ asset('css/atwho.css') }}" rel="stylesheet">
@endsection

<div class="container">
    <div class="row m-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header " style="font-size: 30px;">{{$thread->title}}</div>
                <div class="card-body">
                    {{$thread->body}}
                </div>
                <div class="card-footer">
                    <a href="{{route('user.profile',['user'=>$thread->creator->name])}}">
                        
                        <img src="{{$thread->creator->avatar()}}" alt="" class="ml-2" style="width:30px; height:30px; border-radius:50%;">
                      
                        {{$thread->creator->name}} 
                    </a> Posted This
                </div>
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
                                    <textarea name="reply" class="form-control" id="replyBody" rows="10" cols="60" placeholder="How Do You Think?.." required>{{ old('body') }}</textarea>
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
                    Please <a href="{{route('login')}}">Sign In</a> to post this reply.
                @endif

                <!-- <new-reply></new-reply> -->
        </div>
        <div class="col-md-4 bg-default">
            <div class="list-group">
                <span class="list-group-item list-group-item-action active">
                    Thread Info
                </span>
                <span class="list-group-item list-group-item-action"> Published By <a href="{{route('user.profile',['user'=>$thread->creator->name])}}">{{$thread->creator->name}}</a></span>
                <span class="list-group-item list-group-item-action"> Published at {{\Carbon\Carbon::parse($thread->created_at)->diffForHumans()}}</span>
                <span class="list-group-item list-group-item-action"> {{$thread->replies->count()}} {{ \Str::plural('reply',$thread->replies->count()) }} to this thread</span>
                <span class="list-group-item list-group-item-action"> {{$thread->count_view}} times clicking to this thread</span>
                
                @if(\Auth::check())
                    <span class="list-group-item list-group-item-action"> 
                        <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}"></subscribe-button>
                    </span>
                @endif
                @can('updateThreadPermission',$thread)
                    <span class="list-group-item list-group-item-action">
                        <form action="{{route('thread.destroy',['thread'=> $thread])}}" method="post">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-link">Delete This Thread</button>
                        </form>
                    </span>
                @endcan
            </div>
        <div>
    </div>

   
</div>

@endsection
    
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
     
      

    document.addEventListener('DOMContentLoaded', function () {
        // Your jquery code

        $('#replyBody').atwho({
        at: "@",
        delay:750,
        callbacks: {
            remoteFilter: function(query, callback) {
                $.getJSON("/users", {name: query}, function(data) {
                    callback(data)
                });
            }
        }
        });

       
    });
       
   
    

                // $.ajax({
                //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //     type: 'POST',
                //     url: url,
                //     data: {q:$('.search_mail').val()},
                //     success:function(data){
                    
                //     }
                // });
</script>
