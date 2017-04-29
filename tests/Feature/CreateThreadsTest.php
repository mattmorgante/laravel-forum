<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{

    use DatabaseMigrations;
    /** @test */
    function test_auth_user_can_create_thread() {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\thread')->make();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    // todo: make it so that guests never even get to the method, not that it gets rejected by DB
    function test_guest_cannot_create_thread()
    {
        $this->expectException('Illuminate\Database\QueryException');
        $thread = factory('App\thread')->make();

        $this->post('/threads', $thread->toArray());
    }
}
