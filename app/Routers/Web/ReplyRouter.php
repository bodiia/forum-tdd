<?php

declare(strict_types=1);

namespace App\Routers\Web;

use App\Contracts\Router;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReplyController;
use Illuminate\Support\Facades\Route;

final class ReplyRouter implements Router
{
    public function map(): void
    {
        Route::group(['middleware' => 'auth'], function () {
            Route::post('threads/{channel}/{thread}/replies', [ReplyController::class, 'store'])
                ->name('threads.replies.store');

            Route::delete('replies/{reply}', [ReplyController::class, 'destroy'])
                ->name('replies.destroy');

            Route::patch('replies/{reply}', [ReplyController::class, 'update'])
                ->name('replies.update');

            Route::post('replies/{reply}/favorites', [FavoriteController::class, 'store'])
                ->name('favorites.store');

            Route::delete('replies/{reply}/favorites/{favorite}', [FavoriteController::class, 'destroy'])
                ->name('favorites.destroy');
        });
    }
}
