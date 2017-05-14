<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\thread')->create();
    }

    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    function test_a_user_can_read_a_single_thread() {
        $response = $this->get('/threads/'. $this->thread->channel->slug . '/'. $this->thread->id);
        // or $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /** @test */
    function see_replies_for_thread() {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get('/threads/'. $this->thread->channel->slug . '/'. $this->thread->id);

        $response->assertSee($reply->body);

    }

    /** @test */
    function a_user_can_filter_threads_by_tag() {
        $channel = create('App\Channel');

        $threadInChannel = create('App\thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\thread');

        $this->get('/threads/'. $channel->slug)
            ->assertsee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_username () {
        $this->signIn(create('App\User', ['name' => 'Matt']));

        $threadbyMatt = create('App\thread', ['user_id' => auth()->id()]);
        $threadNotByMatt = create('App\thread');

        $this->get('threads?by=Matt')
            ->assertSee($threadbyMatt->title)
            ->assertDontSee($threadNotByMatt->title);
    }


    /** @test */
    function a_user_can_filter_threads_by_popularity() {
        // 3 threads , with varying numbers of replies
        $threadWithTwoReplies = create('App\thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        // return them from most replies to least
        $response = $this->getJson('threads?popular=1')->json();
        // pop out the replies count from the json and assert it is equal to 3,2,0
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
