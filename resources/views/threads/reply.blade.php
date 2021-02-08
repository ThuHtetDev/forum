<li>
    <p>From <a href="#">{{$reply->owner->name}}</a> said:</p>
    <p>{{$reply->body}}</p>
    <p>{{$reply->created_at->diffForHumans()}}</p>
    <hr>
</li>