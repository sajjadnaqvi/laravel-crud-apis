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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['throttle:uploads'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('user', [UserController::class, 'createUser'])->middleware('auth:api');
    Route::get('users', [UserController::class, 'getAllUsers']);
    Route::get('user/{id}', [UserController::class, 'findUserById']);
    Route::put('user/{id}', [UserController::class, 'updateUser'])->middleware('auth:api');
    Route::delete('user/{id}', [UserController::class, 'deleteUserById'])->middleware('auth:api');
});

