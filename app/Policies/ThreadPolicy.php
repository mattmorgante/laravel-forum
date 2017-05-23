<?php

namespace App\Policies;

use App\User;
use App\thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the thread.
     *
     * @param  \App\User  $user
     * @param  \App\thread  $thread
     * @return mixed
     */
    public function view(User $user, thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can create threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the thread.
     *
     * @param  \App\User  $user
     * @param  \App\thread  $thread
     * @return mixed
     */
    public function update(User $user, thread $thread)
    {
        return $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the thread.
     *
     * @param  \App\User  $user
     * @param  \App\thread  $thread
     * @return mixed
     */
    public function delete(User $user, thread $thread)
    {
        //
    }
}
