<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void{
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }
    /** @test */
    public function a_user_can_browse_all_threads()
    {
        $response = $this->get('/threads')
                    ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_browse_single_thread()
    {
        $response = $this->get($this->thread->path())
                    ->assertSee($this->thread->title);
    }

     /** @test */
     public function a_thread_can_have_replies_that_associated_with_its()
     {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path())
                    ->assertSee($reply->body);
     }

}
