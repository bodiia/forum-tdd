<?php

namespace App\View\Composers;

use App\Models\Channel;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ChannelsComposer
{
    private Collection $channels;

    public function __construct()
    {
        $this->channels = Channel::all();
    }

    public function compose(View $view): void
    {
        $view->with('channels', $this->channels);
    }
}
