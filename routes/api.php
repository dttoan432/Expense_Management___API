<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('/me', [AuthController::class, 'me']);

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])
                ->middleware('ensure.permission:get-users');
            Route::post('/', [UserController::class, 'store'])
                ->middleware('ensure.permission:create-user');
            Route::post('/{id}', [UserController::class, 'update'])
                ->middleware('ensure.permission:update-user');
            Route::delete('/{id}', [UserController::class, 'destroy'])
                ->middleware('ensure.permission:delete-user');
            Route::post('/{id}/update-status-active', [UserController::class, 'updateStatusActive'])
                ->middleware('ensure.permission:update-user-status');
            Route::post('/{id}/update-password', [UserController::class, 'updatePassword'])
                ->middleware('ensure.permission:update-user-password');
        });
    });
});
