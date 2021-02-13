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
        $isFav = $reply->favorite($reply);

        if(request()->expectsJson()){
            return response()->json($isFav,200);
        }
        return back();
    }
}
