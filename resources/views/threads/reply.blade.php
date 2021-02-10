<li>
    <p>From <a href="#">{{$reply->owner->name}}</a> said:</p>
    <p>{{$reply->body}}</p>
    <p>{{$reply->created_at->diffForHumans()}}</p>
    <p>
        <form action="{{route('reply.favorite',['reply' => $reply->id ]) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{$reply->favorites->count()}} {{\Str::plural('Like',$reply->favorites->count())}}
            </button>
        </form>
    </p>
    <hr>
</li>