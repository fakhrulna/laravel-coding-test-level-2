<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ProjectController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); 
});

Route::prefix('/v1')->group(function () {

    Route::middleware('permission:user')->prefix('/user')->group(function () {
        Route::get('/lists', [UserController::class, 'allList'])->name('api.alluser');
        Route::get('/list/{user_id}', [UserController::class, 'list']);
        Route::post('/create', [UserController::class, 'create'])->name('api.usercreate');
        Route::put('/updateIdempotent/{user_id}', [UserController::class, 'updateIdempotent']);
        Route::patch('/update/{user_id}', [UserController::class, 'update']);
        Route::delete('/delete/{user_id}', [UserController::class, 'delete']);
    });

    Route::prefix('/task')->group(function () {
        Route::get('/lists', [TaskController::class, 'allList']);
        Route::get('/list/{task_id}', [TaskController::class, 'list']);
        Route::post('/create', [TaskController::class, 'create'])->middleware('permission:task')->name('api.taskcreate');
        Route::put('/updateIdempotent/{task_id}', [TaskController::class, 'updateIdempotent'])->name('api.taskupdate');
        Route::patch('/update/{task_id}', [TaskController::class, 'update']);
        Route::delete('/delete/{task_id}', [TaskController::class, 'delete'])->middleware('permission:task');
    });

    Route::prefix('/project')->group(function () {
        Route::get('/lists', [ProjectController::class, 'allList']);
        Route::get('/list/{project_id}', [ProjectController::class, 'list']);
        Route::post('/create', [ProjectController::class, 'create'])->middleware('permission:project')->name('api.projectcreate');
        Route::put('/updateIdempotent/{project_id}', [ProjectController::class, 'updateIdempotent'])->middleware('permission:project')->name('api.projectupdate');
        Route::patch('/update/{project_id}', [ProjectController::class, 'update'])->middleware('permission:project');
        Route::delete('/delete/{project_id}', [ProjectController::class, 'delete'])->middleware('permission:project');
    });
});
