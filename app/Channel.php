<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function threads(){
        return $this->hasMany(Thread::class);
    }
}
