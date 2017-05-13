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

        $response = $this->post('/threads', $thread->toArray());



        // now it should be saved to the database

        // does the test actually test the action?

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function test_guest_cannot_create_thread()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    function a_thread_requires_a_title() {
        $this->publishThread(['title' =>null])
            ->assertSessionHasErrors('title');

    }

    /** @test */
    function a_thread_requires_a_body() {
        $this->publishThread(['body' =>null])
            ->assertSessionHasErrors('body');

    }

    /** @test */
    function a_thread_requires_a_valid_channel() {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

    }

    public function publishThread($overrides = []) {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

}
