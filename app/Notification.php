<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class Notification extends Model
{
    protected $fillable = ['message', 'mustBeLoggedIn'];

    // Prepare a message and link it to a screen
    public static function prepare($message, $mustBeLoggedIn = true) {
        // static constructor
        return new static(compact('message', 'mustBeLoggedIn'));
    }

    public function to($url) {
        $this->link = $url;

        return $this;
    }

    // how to test a unit scope?
    public function scopeLatest(Builder $query, $daysBack = 1) {
        return $query->where('created_at', '>', Carbon::now()->subDays($daysBack));
    }
}
