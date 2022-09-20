<?php

namespace App\Http\Controllers;

use App\Models\Channel;

class ChannelController extends Controller
{
    public function index(Channel $channel)
    {
        $threads = $channel->threads()
            ->withCount('replies')
            ->with(['creator', 'channel'])
            ->latest()
            ->get();

        return view('threads.index', compact('threads'));
    }
}
