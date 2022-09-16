<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::resource('threads', ThreadsController::class);

Route::group(['middleware' => 'auth'], function () {
    Route::post('threads/{thread}/replies', [RepliesController::class, 'store'])->name('threads.replies.store');
});

require __DIR__.'/auth.php';
