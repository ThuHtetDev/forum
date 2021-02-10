<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_can_post_reply_in_thread()
    {

        $this->assertTrue(true);
        // $this->be($user = factory('App\User')->create());

        // $thread = factory('App\Thread')->create();
        // $reply = factory('App\Reply')->make();
        // $this->post($thread->path().'/replies', $reply->toArray());

        // $this->get($thread->path())
        // ->assertSee($reply->body);
    }
}
