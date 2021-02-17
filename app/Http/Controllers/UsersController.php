<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
}
