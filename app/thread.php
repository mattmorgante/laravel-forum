<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class thread extends Model
{
    protected $guarded = [];

    // global query scope

    protected static function  boot() {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });
    }

    public function path() {
        // this query runs more than 50 TIMES!!
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies(){
        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply) {
        $this->replies()->create($reply);
    }

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    // call the apply method for the query
    public function scopeFilter($query, $filters) {
        return $filters->apply($query);
    }
}
