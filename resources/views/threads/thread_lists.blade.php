@forelse($threads as $thread)
                <div class="card m-4">
                    <div class="card-header" >
                        <div style="display:flex;">
                            @if(\Auth::check() && $thread->hasVisitedFor())
                                <a href="{{$thread->path()}}" style="flex:1;">
                                    <h4>{{$thread->title}} 
                                        <i class="fa fa-circle"  style="color: #3490DC; font-size:8px;" aria-hidden="true"></i>
                                    </h4>
                                </a>
                            @else
                                <a href="{{$thread->path()}}" style="flex:1;"><h4>{{$thread->title}}</h4></a>
                            @endif

                            <strong>
                                <span style="border:1px solid #ccc; border-radius: 10px; padding: 5px;font-size: 12px;" class="mr-2 ">
                                    {{$thread->count_view}} <i class="fas fa-eye"></i> 
                                </span>
                                <span style="border:1px solid #ccc; border-radius: 10px; padding: 5px;font-size: 12px;">
                                    <a href="{{$thread->path()}}"> 
                                        {{$thread->replies->count()}}
                                        <!-- {{ $thread->replies->count() < 1 ? 'No '. \Str::plural('reply',$thread->replies->count()) : $thread->replies->count() .' '. \Str::plural('reply',$thread->replies->count())}} -->
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                    </a>
                                </span>
                              
                            </strong>
                        </div>
                        <div class="">
                            <span>
                            Posted by
                                <a href="/profiles/{{$thread->creator->name}}">
                                <img src="{{$thread->creator->avatar()}}" alt="" class="ml-1 mr-1" style="width:30px; height:30px; border-radius:50%;">
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