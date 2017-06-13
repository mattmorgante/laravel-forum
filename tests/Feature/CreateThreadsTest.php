<?php

namespace Tests\Feature;

use App\Activity;
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

    /** @test */
    function unauthorized_users_cannot_delete() {
        // NOT SIGNED IN!!
        $this->withExceptionHandling();
        $thread = create('App\thread');
        // not logged in? redirect to login!
        $this->delete($thread->path())->assertRedirect('/login');
        // even if you're signed in, you shouldn't be able to delete everything
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_threads() {
        $this->signIn();

        $thread = create('App\thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['thread_id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);

        $this->assertEquals(0, Activity::count());
    }


}
