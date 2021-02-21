<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class BestReplyController extends Controller
{
    public function store(Reply $reply){
        dd($reply);
        $reply->thread->makeBestRely($reply);
    }
}
