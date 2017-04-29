<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @property  thread
 */
class ThreadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseMigrations;

    protected $thread;

    public function setUp() {
        parent::setUp();

        $this->thread = factory('App\thread')->create();
    }

    function test_thread_has_replies() {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    function a_thread_has_a_creator() {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    function test_a_thread_can_add_a_reply() {
        $this->thread->addReply([
           'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
