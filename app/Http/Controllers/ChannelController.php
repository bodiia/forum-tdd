<?php

namespace App\Http\Controllers;

use App\Models\Channel;

class ChannelController extends Controller
{
    public function index(Channel $channel)
    {
        $threads = $channel->threads()->with(['creator', 'channel'])->latest()->get();

        return view('threads.index', compact('threads'));
    }
}
