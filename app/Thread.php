<?php

namespace App;

use App\User;
use App\Reply;
use App\Channel;
use Carbon\Carbon;
use App\Events\ThreadReceivedReply;
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

    public function getRouteKeyName(){
        return 'slug';
    }

    public function path(){
        return "/threads/{$this->channel->slug}/{$this->slug}";
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
        //! Create Reply from thread
        $reply = $this->replies()->create($data);
        
        //! Mentioned user notify
        event(new ThreadReceivedReply($reply)); // Call Events+Listeners Methods 
        
        //! Subscribe user notify
        $this->notifySubcribers($reply); // Call Notify Subscribers


        return $reply;
    }

    public function notifySubcribers($reply){
        //! If Reply cames to thread, Send/Create Notifications to that thread's subscribers
        $this->subscriptions->filter(function ($sub) use ($reply){
            // reply user cannot be auth user
            return $sub->user_id != $reply->user_id;
        })
        ->each(function ($sub) use ($reply){
            $sub->notify($reply);
        });

        //! Other ways noted
        // ->each(function ($sub) use ($reply){
        //     $sub->user->notify(new ThreadWasUpdated($this,$reply));
        // });

        // foreach($this->subscriptions as $subscription){
        //     if($subscription->user_id != $reply->user_id){
        //         $subscription->user->notify(new ThreadWasUpdated($this,$reply));
        //     }
        // }
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query,$filters){
        return $filters->apply($query);
    }

    public function subscriptions(){
        return $this->hasMany(ThreadSubscription::class);
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
        if(\Auth::check()){
            return $this->subscriptions()->where('user_id',\Auth::user()->id)->exists();
        }
        return false;
    }

    public function hasVisitedFor(){
        $key = sprintf("users.%s.visits.%s",\Auth::user()->id,$this->id);
        
        return $this->updated_at > cache($key);
    }

    public function setSlugAttribute($value){
        $this->attributes['slug'] = \Str::slug($value).'-'.Carbon::now()->timestamp;
    }

    // Mark as Best Reply to Thread
    public function makeBestRely(Reply $reply){
        $this->update(['best_reply_id' => $reply->id]);
    }

    public function CancelBestRely(Reply $reply){
        $this->best_reply_id = null;
        $this->update();
        return ;
    }

}
