<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index(){
        $search = request('name');
        $users = User::whereRaw("REPLACE(`name`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $search).'%'])
                    ->take(5)
                    ->pluck('name');
                 
        $data = [];
        foreach($users as $user){
            $data[] =str_replace(' ', '', $user);
        }

        // $users =  User::where("name","LIKE","$search%")
        //             ->take(5)
        //             ->pluck('name');

        return response()->json(collect($data),200);
    }

    public function storeAvator(){
        //Validate Avator
        $this->validate(request(),[
            'avatar' => ['required','image']
        ]);
        // Save into user's DB
        $file = request()->file('avatar');
        $current_timestamp = Carbon::now()->timestamp;
        $file_name = $current_timestamp . "_" . $file->getClientOriginalName();
        $extension = $file->extension();
        $file->storeAs('/public/avatars/', $file_name. "." .$extension);
        $file_url = Storage::url("avatars/" .$file_name. "." .$extension);

        Auth::user()->update([
            'avatar_path' => $file_url
        ]);

        return back()->with('flash','Your Profile Image Uploaded');
    }
}
