<?php

declare(strict_types=1);

namespace App\Routers\Web;

use App\Contracts\Router;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

final class HomeRouter implements Router
{
    public function map(): void
    {
        Route::get('/', HomeController::class)->name('home');
    }
}
