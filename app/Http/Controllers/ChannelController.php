<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\View\View;

class ChannelController extends Controller
{
    public function index(Channel $channel): View
    {
        $threads = $channel->threads()
            ->withCount('replies')
            ->with(['creator', 'channel'])
            ->latest()
            ->get();

        return view('threads.index', compact('threads'));
    }
}
