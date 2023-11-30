<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Dashboard routes.
 */
Route::redirect('/', '/dashboard');

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Dashboard\Home\HomeController::class, 'index'])->name('home');

    Route::prefix('bots')->name('bots.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\Bots\BotController::class, 'index'])->name('index');

        Route::prefix('taskablebot')->name('taskablebot.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Dashboard\Bots\Taskable\TaskableController::class, 'index'])->name('index');

            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Dashboard\Bots\Taskable\Users\TaskableUsersController::class, 'index'])->name('index');
            });
        });

        Route::prefix('anonimyozbot')->name('anonimyozbot.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Dashboard\Bots\Anonimyoz\AnonimyozController::class, 'index'])->name('index');

            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Dashboard\Bots\Anonimyoz\Users\AnonimyozUsersController::class, 'index'])->name('index');
            });
        });
    });
})->middleware(['auth', 'verified']);
