<?php

use App\Http\Controllers\MattTestController;
use App\Livewire\Players\DetailView as PlayersDetailView;
use App\Livewire\Players\ListView as PlayersListView;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome'); In case this is required later, you can put it back !
Route::redirect('/', 'login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    Route::prefix('players')->group(function () {
        Route::get('', PlayersListView::class)->name('players');
        Route::get('details/{id}', PlayersDetailView::class)->name('player.detail');
    });
});

require __DIR__ . '/auth.php';
