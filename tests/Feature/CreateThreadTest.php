<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_new_threads()
    {
        // $this->actingAs(factory(User::class)->create()); //create auth user
        $thread = factory(Thread::class)->make();
        $this->post('/threads',$thread->toArray());
        // $this->assertTrue(true);
        $response = $this->get('/threads/'.$thread->id)
                    ->assertSee($thread->title)
                    ->assertSee($thread->body);
    }
}
