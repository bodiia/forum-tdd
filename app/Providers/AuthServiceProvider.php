<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\ThreadSubscription;
use App\Policies\FavoritePolicy;
use App\Policies\ReplyPolicy;
use App\Policies\ThreadPolicy;
use App\Policies\ThreadSubscriptionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Thread::class => ThreadPolicy::class,
        Reply::class => ReplyPolicy::class,
        Favorite::class => FavoritePolicy::class,
        ThreadSubscription::class => ThreadSubscriptionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
