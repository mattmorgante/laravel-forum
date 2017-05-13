<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\thread;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelId
     * @param thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, thread $thread) {

        $this->validate(request(),[
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
