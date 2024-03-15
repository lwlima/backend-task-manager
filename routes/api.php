<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
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

Route::post('/sign-in', [AuthUserController::class, 'signIn']);

// Route::middleware(['auth:sanctum', 'throttle:200,1'])->group(function () {
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user',  [AuthUserController::class, 'getUserAuth']);
    Route::get('/users', [AuthUserController::class, 'getUsers']);
    Route::post('/logout', [AuthUserController::class, 'logout']);

    Route::get('/task-status', [TaskStatusController::class, 'index']);

    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::put('/{id}', [TaskController::class, 'update']);
        Route::delete('/{id}', [TaskController::class, 'destroy']);
    });
});
