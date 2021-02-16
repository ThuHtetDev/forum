<?php

namespace App\Http\Controllers;

use App\User;
use App\Thread;
use App\Channel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use Illuminate\Support\Facades\Auth;

class ThreadsController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index','show');
    }

    public function index(Channel $channel,ThreadFilters $filters){
        $threads = $this->getThreads($channel,$filters);
        return view('threads.index',compact('threads'));
    }

    private function getThreads($channel,$filters){
        $threads = Thread::latest()->filter($filters); // add edger loading for channel relationship
        if($channel->exists){
            // $channelId = Channel::where('slug',$channel)->first()->id;
            // $threads = $channel->threads()->latest();
            $threads->where('channel_id',$channel->id);
        }
        $threads = $threads->get();
        return $threads;
    }

    public function show($channelId,Thread $thread){
        // Record user visit this page
        // Record timestamp as cache
        // Caching
        $key = sprintf("users.%s.visits.%s",\Auth::user()->id,$thread->id);
        cache()->forever($key,Carbon::now());
        
        return view('threads.show',[
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(10)
        ]);
    }

    public function create(){
        return view('threads.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

       $thread = Thread::create([
           'user_id' => Auth::user()->id,
           'channel_id' => $request->channel_id,
           'title' => $request->title,
           'body' => $request->body
       ]);

       return redirect($thread->path())
                ->with('flash','New thread has been created');
    }

    public function destroy(Thread $thread){
        $this->authorize('updateThreadPermission',$thread);
        $thread->replies()->delete();
        $thread->delete();
        return redirect('/threads');
    }


}
