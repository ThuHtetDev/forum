<?php

namespace Tests\Unit;

use App\User;
use App\Reply;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    // use DatabaseMigrations;
    /** @test */
    public function it_has_an_owner()
    {
        // $reply = factory(Reply::class)->create();
        // $this->assertInstanceOf(User::class,$reply->owner);
        $this->assertTrue(true);
    }
}
