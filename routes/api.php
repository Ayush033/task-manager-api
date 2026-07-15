<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//  models
use App\Models\Task;
use App\Models\Category;

//  controllers
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
    return $request->user();
    });

    Route::apiResource('tasks', TaskController::class);

    Route::get('/category', function(){
    return Category::all();
});
});

