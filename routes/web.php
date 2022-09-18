<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::resource('threads', ThreadController::class)->except('show');

Route::get('threads/{channel}', [ChannelController::class, 'index'])->name('threads.channel.index');
Route::get('threads/{channel}/{thread}', [ThreadController::class, 'show'])->name('threads.show');

Route::post('threads/{channel}/{thread}/replies', [ReplyController::class, 'store'])->name('threads.replies.store');

require __DIR__.'/auth.php';
