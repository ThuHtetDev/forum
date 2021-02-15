<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    public function index(){
     
        $notifications = Auth::user()->unreadNotifications;
        return response()->json($notifications,200);
    }

    public function destory(User $user,$notificationId){
        Auth::user()->notifications()->find($notificationId)->markAsRead();
        return response()->json('success',200);
    }
}
