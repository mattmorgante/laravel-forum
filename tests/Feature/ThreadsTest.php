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
        $response = $this->get('/threads/' . $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test */
    function see_replies_for_thread() {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get('/threads/'. $this->thread->id);

        $response->assertSee($reply->body);

    }
}
