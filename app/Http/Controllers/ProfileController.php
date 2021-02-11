<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   public function show(User $user){
       // User $user is route model binding
       // User default accept is id
       // But change to RouteKeyName in User.php => as name
       return view('profiles.show',[
           'user' => $user,
           'threads' => $user->threads()->paginate(20)
       ]);
   }
}
