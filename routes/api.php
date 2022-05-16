<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

        // Quản lý người dùng
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])
                ->middleware('ensure.permission:get-users');
            Route::get('/all-roles', [UserController::class, 'getAllRoles'])
                ->middleware('ensure.permission:create-user,update-user');
            Route::post('/', [UserController::class, 'store'])
                ->middleware('ensure.permission:create-user');
            Route::post('/{id}', [UserController::class, 'update'])
                ->middleware('ensure.permission:update-user');
            Route::post('/{id}/update-status-active', [UserController::class, 'updateStatusActive'])
                ->middleware('ensure.permission:update-user-status');
            Route::post('/{id}/update-password', [UserController::class, 'updatePassword'])
                ->middleware('ensure.permission:update-user-password');
            Route::delete('/{id}', [UserController::class, 'destroy'])
                ->middleware('ensure.permission:delete-user');
        });

        // Quản lý vai trò
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])
                ->middleware('ensure.permission:get-roles');
            Route::post('/', [RoleController::class, 'store'])
                ->middleware('ensure.permission:create-role');
            Route::post('/{id}', [RoleController::class, 'update'])
                ->middleware('ensure.permission:update-role');
            Route::post('/{id}/update-permission', [RoleController::class, 'updatePermissionForRoles'])
                ->middleware('ensure.permission:update-permissions-for-role');
            Route::post('/{id}/remove-permissions', [RoleController::class, 'update'])
                ->middleware('ensure.permission:update-permissions-for-role');
            Route::delete('/{id}', [RoleController::class, 'destroy'])
                ->middleware('ensure.permission:delete-role');
        });

        // Quản lý quyền
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'index'])
                ->middleware('ensure.permission:get-permissions');
        });
    });
});
