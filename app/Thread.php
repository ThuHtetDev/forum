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

    protected $appends = ['isSubscribedTo'];


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
        $reply = $this->replies()->create($data);

        foreach($this->subscriptions as $subscription){
            $subscription->user->notify(new ThreadWasUpdated($this,$reply));
        }

        return $reply;
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query,$filters){
        return $filters->apply($query);
    }

    public function subscribed($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: \Auth::user()->id
        ]);
    }

    public function unsubscribed($userId = null)
    {
        $this->subscriptions()->where('user_id' , $userId ?: \Auth::user()->id)->delete();
    }

    public function getIsSubscribedToAttribute(){
        return $this->subscriptions()->where('user_id',\Auth::user()->id)->exists();
    }

    public function subscriptions(){
        return $this->hasMany(ThreadSubscription::class);
    }
}
