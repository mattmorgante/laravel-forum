<?php

use App\Notification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NotificationTest extends TestCase {
    // describe what it does
    use DatabaseMigrations;

    /** @test */
    function it_prepares_a_notification() {
        $notification = Notification::prepare('a message');
        $this->assertEquals('a message', $notification->message);
        $this->assertTrue($notification->mustBeLoggedIn);
        $this->assertFalse($notification->exists);
    }

    /** @test */
    function it_sets_the_url_for_the_notification() {
        $notification = Notification::prepare('a message')->to('http://example.com');

        $this->assertEquals('http://example.com', $notification->link);
    }

    /** @test */
    function it_scopes_queries() {
        // we have a new notification
        factory('App\Notification')->create();

        // we have an old notification

        factory('App\Notification')->create([
            'created_at' => Carbon::now()->subWeek()
        ]);

        // scope notification
        $results = Notification::latest()->get();

        // only get one result
        $this->assertCount(1, $results);
    }
}