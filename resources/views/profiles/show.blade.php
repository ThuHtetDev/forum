@extends('layouts.app')
@section('content')
   
    <div class="container">
        <div class="jumbotron" style="display:flex;">
        <div style="flex:1;">
                <h1 class="display-4">{{$user->name}}</h1>
                <p class="lead">
                    Member Since {{$user->created_at->diffForHumans()}}
                </p>
                @can('updateProfilePermission',$user)
                    <form action="{{route('user.avatar',['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                @endCan
        </div>
        @if($user->avatar_path)
            <div>
                <img src="{{$user->avatar_path}}" alt="" style="width:200px; height:200px; border-radius:50%;">
            </div>    
        @endif

            
        </div>
        <div class="row">
        <div class="col-md-8" >
            @foreach($threads as $thread)
                <div class="card m-4">
                    <div class="card-header" style="display:flex;">
                        <a href="{{$thread->path()}}" style="flex:1;"><h3>{{$thread->title}}</h3></a>
                        <strong><a href="{{$thread->path()}}"> {{ $thread->replies->count() < 1 ? 'No '. \Str::plural('reply',$thread->replies->count()) : $thread->replies->count() .' '. \Str::plural('reply',$thread->replies->count())}}</a></strong>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4" >
            <div class="list-group m-4">
                History
            </div>
        </div>
    </div>
    </div>
@endsection