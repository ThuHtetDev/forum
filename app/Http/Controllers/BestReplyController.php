<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class BestReplyController extends Controller
{
    public function store(Reply $reply){
        $this->authorize('updateThreadPermission',$reply->thread);
        $reply->thread->makeBestRely($reply);
    }

    public function destroy(Reply $reply){
        $this->authorize('updateThreadPermission',$reply->thread);
        $reply->thread->CancelBestRely($reply);
    }
}
