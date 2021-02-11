<?php

namespace App;

use App\User;
use App\Reply;
use App\Channel;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    protected $with = ['channel'];

    protected static function boot(){
        parent::boot();

        // Edger Loading add in Global
        // this can be included creator in Thread
        // can also be remove by withoutGlobalScopes()
        static::addGlobalScope('creator',function($builder){
            $builder->with('creator');
        });
    }

    public function path(){
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies(){
        return $this->hasMany(Reply::class)
                    ->withCount('favorites')
                    ->with('owner');
    }

    public function creator(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function addReply($data){
  
        $this->replies()->create($data);
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query,$filters){
        return $filters->apply($query);
    }
}
