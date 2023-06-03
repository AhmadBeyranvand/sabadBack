<?php

use App\Http\Controllers\BuyerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FactorController;
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

Route::middleware(['cors'])->group(function () {
    Route::get('/newFactor', [FactorController::class, "new"]);
    Route::get('/allFactors', [FactorController::class, "showAll"]);
    Route::get('/showFactor', [FactorController::class, "show"]);

    Route::get('/allBuyers',  [BuyerController::class, "showAll"]);
    Route::get('/newBuyer',  [BuyerController::class, "new"]);
    Route::get('/showBuyer', [BuyerController::class, "show"]);
    Route::get('/showBuyerByPhone', [BuyerController::class, "showPhone"]);

    Route::get('/allDrivers',  [DriverController::class, "showAll"]);
    Route::get('/showDriver', [DriverController::class, "show"]);
    Route::get('/showDriverByPhone', [DriverController::class, "showPhone"]);
    Route::get('/newDriver', [DriverController::class, "new"]);

    Route::get('/debters', [FactorController::class, "showDebters"]);
    Route::get('/debt/{userID}', [FactorController::class, "showDebtOf"]);

    Route::get('/clearFactor/{factorID}', [FactorController::class, "clearFactor"]);
    Route::get('/clearUser/{userID}', [FactorController::class, "clearUser"]);

    Route::get('/stats', [FactorController::class, "stats"]);
});
