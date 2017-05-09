<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads() {
        // add reply

        $this->signIn();

        $thread = create('App\thread');

        $reply = make('App\Reply');
        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    function guests_may_not_reply() {

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\thread');

        $reply = make('App\Reply');
        $this->post($thread->path().'/replies', $reply->toArray());

    }

}