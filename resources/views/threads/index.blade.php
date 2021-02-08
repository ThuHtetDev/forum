<h1>Forum Threads</h1>

<ul>
    @foreach($threads as $thread)
        <a href="{{$thread->path()}}"><h3>{{$thread->title}}</h3></a>
        <p>{{$thread->body}}</p>
    @endforeach
</ul>