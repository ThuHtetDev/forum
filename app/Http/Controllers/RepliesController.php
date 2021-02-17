<?php

namespace App\Http\Controllers;

use App\User;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\YouWereMentioned;

class RepliesController extends Controller
{
    public function store($channelId,Thread $thread){
        $this->validate(request(),[
            'reply' => 'required'
        ]);
        $reply = $thread->addReply([
                    'body' => request('reply'),
                    'user_id' => Auth::user()->id
                ]);

        if(request()->expectsJson()){
            return response()->json('success',201);
        }

        return back()->with('flash','Your Reply has been posted');
    }

    public function destory(Reply $reply){
        $this->authorize('updateReplyPermission',$reply);
        $reply->delete();
        if(request()->expectsJson()){
            return response()->json('success',200);
        }
        return back()->with('flash','Your reply has been deleted');
    }

    public function update(Reply $reply,Request $request){
        $reply->body = $request->body;
        $reply->update();
        return 'success';
    }
}
