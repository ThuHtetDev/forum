<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index','show');
    }

    public function store(Reply $reply,Request $request){
        $reply->favorite($reply);
        return back();
    }
}
