<h1>Forum Threads Detail</h1>
<hr>
<p>Posted by <a href="#">{{$thread->creator->name}}</a> </p>
<h3>{{$thread->title}}</h3>
<p>{{$thread->body}}</p>
<hr>
<ul>
    @foreach($thread->replies as $reply)
        @include('threads.reply')
    @endforeach
</ul>
    @if(\Auth::check())
    <div>
        <form action="{{$thread->path().'/replies'}}" method="POST">
            @csrf 
            <textarea name="reply" id="" cols="30" rows="10" placeholder="How Do You Think?.."></textarea>
            <button type="submit">Post</button>
        </form>
    </div>
    @else
        Please <a href="{{route('login')}}">Signin</a> to post this reply.
    @endif