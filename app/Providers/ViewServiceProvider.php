<?php

namespace App\Providers;

use App\View\Composers\ChannelsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ChannelsComposer::class);
    }

    public function boot(): void
    {
        View::composer(['layouts.navigation', 'threads.create'], ChannelsComposer::class);
    }
}
