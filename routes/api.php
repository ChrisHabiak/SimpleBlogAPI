<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AuthController;
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

Route::get('/', function () {
    return response()->json([
        'status' => 'active',
        'version' => '1.0'
    ]);
});

// Resourceful route for managing posts
Route::resource('posts', PostsController::class);

// Authentication-related routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('send-reset-password-link', [AuthController::class, 'sendResetPasswordLink']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Routes protected by the Sanctum authentication middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UsersController::class);
});

