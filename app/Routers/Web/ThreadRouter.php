<?php

declare(strict_types=1);

namespace App\Routers\Web;

use App\Contracts\Router;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ThreadSubscriptionController;
use Illuminate\Support\Facades\Route;

final class ThreadRouter implements Router
{
    public function map(): void
    {
        Route::group(['middleware' => 'auth'], function () {
            Route::resource('threads', ThreadController::class)->except(['show', 'index', 'destroy']);

            Route::post('threads/{thread}/subscriptions', [ThreadSubscriptionController::class, 'store'])
                ->name('threads.subscriptions.store');

            Route::delete('threads/{thread}/subscriptions', [ThreadSubscriptionController::class, 'destroy'])
                ->name('threads.subscriptions.destroy');

            Route::delete('threads/{channel}/{thread}', [ThreadController::class, 'destroy'])
                ->name('threads.channel.destroy');
        });

        Route::get('threads', [ThreadController::class, 'index'])
            ->name('threads.index');

        Route::get('threads/{channel}', [ChannelController::class, 'index'])
            ->name('threads.channel.index');

        Route::get('threads/{channel}/{thread}', [ThreadController::class, 'show'])
            ->name('threads.show');
    }
}
