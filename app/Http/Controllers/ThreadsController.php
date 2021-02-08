<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadsController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only('store');
    }

    public function index(){
        $threads = Thread::latest()->get();
        return view('threads.index',compact('threads'));
    }

    public function show(Thread $thread){
        return view('threads.show',compact('thread'));
    }

    public function store(Request $request){
       $thread = Thread::create([
           'user_id' => Auth::user()->id,
           'title' => $request->title,
           'body' => $request->body
       ]);

       return redirect($thread->path());
    }
}
