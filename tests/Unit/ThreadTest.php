<?php

namespace Tests\Unit;

use App\Thread;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    protected $thread;

    public function setUp(): void{
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }
    /** @test */
    function a_thread_has_replies()
    {
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' ,$this->thread->replies);
    }
     /** @test */
     public function a_thread_has_creator()
     {
         
         $this->assertInstanceOf('App\User' ,$this->thread->creator);
     }

     /** @test */
     public function a_thread_can_have_replies()
     {
         
         $this->thread->addReply([
             'body' => 'foobar',
             'user_id' => 1
         ]);
        $this->assertCount(1,$this->thread->replies);
     }
}
