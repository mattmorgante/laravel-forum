<?php

namespace App\Filters;
use App\User;

class ThreadFilters extends Filters
{

    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username
     * @param $username
     * @return mixed
     * @internal param $builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    // filter query
    protected function popular() {
        // go to the query builder and clear out the ORDER variable
        // without this, default sort by "created_at" will override replies count, even when popular is specified
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }
}