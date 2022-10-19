<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ThreadSubscriptionController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)
    ->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('threads', ThreadController::class)->except(['show', 'index', 'destroy']);

    Route::post('threads/{thread}/subscriptions', [ThreadSubscriptionController::class, 'store'])
        ->name('threads.subscriptions.store');

    Route::delete('threads/{thread}/subscriptions', [ThreadSubscriptionController::class, 'destroy'])
        ->name('threads.subscriptions.destroy');

    Route::post('threads/{channel}/{thread}/replies', [ReplyController::class, 'store'])
        ->name('threads.replies.store');

    Route::post('replies/{reply}/favorites', [FavoriteController::class, 'store'])
        ->name('favorites.store');

    Route::delete('replies/{reply}/favorites/{favorite}', [FavoriteController::class, 'destroy'])
        ->name('favorites.destroy');

    Route::delete('threads/{channel}/{thread}', [ThreadController::class, 'destroy'])
        ->name('threads.channel.destroy');

    Route::delete('replies/{reply}', [ReplyController::class, 'destroy'])
        ->name('replies.destroy');

    Route::patch('replies/{reply}', [ReplyController::class, 'update'])
        ->name('replies.update');

    Route::delete('profiles/{user}/notifications/{notification}', [UserNotificationController::class, 'destroy'])
        ->name('user.notifications.destroy');
});

Route::get('threads', [ThreadController::class, 'index'])
    ->name('threads.index');

Route::get('threads/{channel}', [ChannelController::class, 'index'])
    ->name('threads.channel.index');

Route::get('threads/{channel}/{thread}', [ThreadController::class, 'show'])
    ->name('threads.show');

Route::get('profiles/{user}', [ProfileController::class, 'show'])
    ->name('profiles.show');

require __DIR__.'/auth.php';
