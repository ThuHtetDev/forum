@forelse($threads as $thread)
                <div class="card m-4">
                    <div class="card-header" >
                        <div style="display:flex;">
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
                        <div class="">
                            <span>
                            Posted by
                                <a href="/profiles/{{$thread->creator->name}}">
                                    {{$thread->creator->name}}
                                </a>
                            </span>
                        </div>
                    </div>
                   
                    <div class="card-body">
                        {{\Str::limit($thread->body, 50)}}...
                    </div>
                </div>
            @empty
                <div>There is no threads till now. Be the first one:</div>
            @endforelse