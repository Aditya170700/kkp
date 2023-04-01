<?php

use App\Http\Controllers\API\Admin\ShipController as AdminShipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\User\ShipController;

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

Route::group(['prefix' => 'api'], function () {
    Route::controller(AuthController::class)
        ->prefix('auth')
        ->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');

            Route::group(['middleware' => 'auth'], function () {
                Route::get('otp', 'otp');
                Route::post('check-otp', 'checkOtp');
            });
        });

    Route::group([
        'middleware' => ['role:admin', 'verified.user'],
        'prefix' => 'admin'
    ], function () {
        Route::controller(UserController::class)
            ->prefix('user')
            ->group(function () {
                Route::get('/', 'index');
                Route::put('/{user}/verify', 'verify');
            });

        Route::controller(AdminShipController::class)
            ->prefix('ship')
            ->group(function () {
                Route::get('/', 'index');
                Route::put('/{ship}/update', 'update');
            });
    });

    Route::group([
        'middleware' => ['role:user', 'verified.user'],
        'prefix' => 'user'
    ], function () {
        Route::controller(ShipController::class)
            ->prefix('ship')
            ->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
                Route::put('/{ship}/update', 'update');
            });
    });
});
