<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Admin\UserController;

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
    });

    Route::group([
        'middleware' => ['role:user', 'verified.user'],
        'prefix' => 'user'
    ], function () {
        Route::get('/', function () {
            dd(auth()->user());
        });
    });
});
