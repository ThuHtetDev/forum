<?php

namespace App;

use App\User;
use App\Thread;
use App\Favorite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    protected $with = ['owner','favorites'];

    protected $appends = ['isFavorited','isBest'];
    
    public function thread(){
        return $this->belongsTo(Thread::class);
    }

    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function favorites(){
        return $this->morphMany(Favorite::class,'favorited');
    }

    public function isFavorited(){
        if(\Auth::check()){
            return !! $this->favorites->where('user_id',\Auth::user()->id)->count();
        }
        return false;
    }

    public function path(){
        return $this->thread->path().'#reply-'.$this->id;
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function favorite($reply){
        $existFavorite = Favorite::where('user_id',\Auth::user()->id)
                        ->where('favorited_id',$reply->id)
                        ->first();
        if(!is_null($existFavorite)){
            $existFavorite->delete();
            return false;
        }

        $this->favorites()->create(['user_id' => \Auth::user()->id]);
        return true;
    }

    public function isBest(){
        return $this->thread->best_reply_id == $this->id;
    }
    // Get Mutators
    public function getIsBestAttribute(){
        return $this->isBest();
    }

    // public function wasJustPublished(){
    //     return $this->created_at->gt(Carbon::now()->subMinute());
    // }
}
