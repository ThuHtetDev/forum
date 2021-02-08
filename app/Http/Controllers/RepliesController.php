<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function store(Thread $thread){
        $thread->addReply([
            'body' => request('reply'),
            'user_id' => Auth::user()->id
        ]);
        return back();
    }
}
