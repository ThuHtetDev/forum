<?php

namespace App;

use App\Reply;
use App\Thread;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName(){
        return 'name';
    }

    public function threads(){
        return $this->hasMany(Thread::class);
    }

    public function avatar(){
        return $this->avatar_path ?: '/storage/avatars/default_avatar.png';
    }

    // public function visitUserCacheKey($thread){
    //     return sprintf("users.%s.visits.%s",\Auth::user()->id,$thread->id);
    // }

    // public function lastReply()
    // {
    //     return $this->hasOne(Reply::class)->latest();
    // }
}
