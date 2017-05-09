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
        $this->actingAs(create('App\User'));

        $thread = make('App\thread');

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    function test_guest_cannot_create_thread()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');


        $this->post('/threads')
            ->assertRedirect('/login');

    }

}
