<?php

declare(strict_types=1);

namespace App\Routers\Web;

use App\Contracts\Router;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;

final class UserRouter implements Router
{
    public function map(): void
    {
        Route::group(['middleware' => 'auth'], function () {
            Route::delete('profiles/{user}/notifications/{notification}', [UserNotificationController::class, 'destroy'])
                ->name('user.notifications.destroy');

            Route::patch('users/{user}/avatar', [UserController::class, 'update'])
                ->name('user.avatar.update');
        });

        Route::get('profiles/{user}', [ProfileController::class, 'show'])
            ->name('profiles.show');
    }
}
