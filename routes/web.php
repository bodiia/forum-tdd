<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::resource('threads', ThreadController::class);

Route::post('threads/{thread}/replies', [ReplyController::class, 'store'])->name('threads.replies.store');

require __DIR__.'/auth.php';
