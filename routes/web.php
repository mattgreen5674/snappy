<?php

use App\Http\Controllers\MattTestController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome'); In case this is required later, you can put it back !
Route::redirect('/', 'login');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    Route::controller(MattTestController::class)
        ->prefix('matt')
        ->group(function () {
            Route::get('', 'index')->name('matt');
        });

});

require __DIR__ . '/auth.php';
