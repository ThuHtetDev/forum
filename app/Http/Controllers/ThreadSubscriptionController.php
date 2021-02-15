<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller
{
    public function store($channelId,Thread $thread){
        $thread->subscribed();
        return response()->json('success',201);
    }

    public function destroy($channelId,Thread $thread){
        $thread->unsubscribed();
        return response()->json('success',200);
    }
}
