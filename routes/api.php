<?php

use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->group(function () {

        Route::controller(ShopController::class)
            ->prefix('shops')
            ->group(function () {
                Route::post('near-to-postcode', 'nearToPostCode')->name('shops.near_to_postcode');
                Route::post('will-deliver-to-postcode', 'willDeliverToPostCode')->name('shops.will_deliver_to_postcode');
            });

        Route::prefix('/user')->group(function () {
            Route::get('', function (Request $request) {
                return $request->user();
            });
        });
    });