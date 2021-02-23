
@extends('layouts.app')
@section('content')

@section('header-css')
    <link href="{{ asset('css/atwho.css') }}" rel="stylesheet">
@endsection
<thread-view :initial-reply-count="{{$thread->replies->count()}}" inline-template>
    <div class="container">
        <div class="row m-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="font-size: 30px;">{{$thread->title}}</div>
                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                    <div class="card-footer">
                        <a href="{{route('user.profile',['user'=>$thread->creator->name])}}">
                            
                            <img src="{{$thread->creator->avatar()}}" alt="" class="ml-2" style="width:30px; height:30px; border-radius:50%;">
                        
                            {{$thread->creator->name}} 
                        </a> Posted This Thread
                    </div>
                </div>
                    <ul class="m-5">
                        <replies :data="{{$thread->replies}}" @added="repliesCount++" @removed="repliesCount--"></replies>
                        {{-- {{$replies->links()}} --}}
                    </ul>

                    
            </div>
            <div class="col-md-4 bg-default">
                <div class="list-group">
                    <span class="list-group-item list-group-item-action active">
                        Thread Info
                    </span>
                    <span class="list-group-item list-group-item-action"> Published By <a href="{{route('user.profile',['user'=>$thread->creator->name])}}">{{$thread->creator->name}}</a></span>
                    <span class="list-group-item list-group-item-action"> Published at {{\Carbon\Carbon::parse($thread->created_at)->diffForHumans()}}</span>
                    <span class="list-group-item list-group-item-action"> <span v-text="repliesCount"></span> replies to this thread</span>
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
                                <button type="submit" class="btn btn-link text-danger">Delete This Thread</button>
                            </form>
                        </span>
                        <span class="list-group-item list-group-item-action"> 
                            <a href="{{$thread->path() . '/edit'}}">
                                <button type="submit" class="btn btn-link text-danger">Edit This Thread</button>
                            </a>
                            
                        </span>
                    @endcan
                </div>
            <div>
        </div>

    
    </div>
</thread-view>
@endsection

<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     // Your jquery code

    //     $('#replyBody').atwho({
    //     at: "@",
    //     delay:750,
    //     callbacks: {
    //         remoteFilter: function(query, callback) {
    //             $.getJSON("/users", {name: query}, function(data) {
    //                 callback(data)
    //             });
    //         }
    //     }
    //     });
// });
    // $.ajax({
    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //     type: 'POST',
    //     url: url,
    //     data: {q:$('.search_mail').val()},
    //     success:function(data){
    //     }
    // });
</script>
