<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    protected $guarded = [];
    protected $table = 'thread_subscriptions';

    public function user(){
        return $this->belongsTo($user);
    }
}
