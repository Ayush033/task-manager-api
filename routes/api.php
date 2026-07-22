<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//  models
use App\Models\Task;
use App\Models\Category;

//  controllers
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
    return $request->user();
    });

    Route::apiResource('tasks', TaskController::class);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('categories/{name}/tasks', [CategoryController::class, 'getTasksByCategory']);
    Route::post('categories/{category}/tasks/{task}', [CategoryController::class, 'addCategory']);
    Route::delete('categories/{category}/tasks/{task}', [CategoryController::class, 'removeCategory']);
});