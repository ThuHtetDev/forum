<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedReply;
use App\Notifications\YouWereMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedReply  $event
     * @return void
     */
    public function handle(ThreadReceivedReply $event)
    {
        // Find the @name withing body
        $pattern = '/@([\w\-]+)/';
        preg_match_all($pattern,$event->reply->body,$matches);
        // If found, cut only names
        $names = $matches[1];

        // Search in User
        collect($names)
        ->map(function($name){
            return User::whereRaw("REPLACE(`name`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $name).'%'])
                    ->first();
            // return User::where('name',$name)->first();
        })
        ->filter()
        ->each(function ($user) use ($event){
            // Notify them
            $user->notify(new YouWereMentioned($event->reply));
        });

        //! Simple way
        // foreach($names as $name){
        //     $user = User::whereName($name)->first();
        //     if($user){
        //         // Notify them
        //         $user->notify(new YouWereMentioned($event->reply));
        //     }
        // }
    }
}
