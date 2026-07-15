<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//  models
use App\Models\Task;
use App\Models\Category;

//  controllers
use App\Http\Controllers\TaskController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('tasks', TaskController::class);

Route::get('/category', function(){
    return Category::all();
});
