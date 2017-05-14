<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_can_not_fav() {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');

    }

    /** @test */
    public function an_auth_user_can_favorite_any_reply() {
        $this->signIn();
        // thread is created automatically by the factory
        $reply = create('App\Reply');
        // if i post to a "favorite" endpoint
        // endpoint = replies/id/favorites
        $this->post('replies/'. $reply->id . '/favorites');
        // it should be recorded in the database
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_auth_user_can_favorite_a_reply_once() {
        $this->signIn();
        // thread is created automatically by the factory
        $reply = create('App\Reply');
        // if i post to a "favorite" endpoint
        // endpoint = replies/id/favorites
        try{
            $this->post('replies/'. $reply->id . '/favorites');
            $this->post('replies/'. $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Same user cannot favorite same reply twice');
        }
        // it should be recorded in the database
        $this->assertCount(1, $reply->favorites);
    }
}