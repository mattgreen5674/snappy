<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->group(function () {

        Route::prefix('user')->group(function () {
            Route::get('', function (Request $request) {
                return $request->user();
            });
        });

    });
