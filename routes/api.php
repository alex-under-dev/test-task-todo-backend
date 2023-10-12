<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\TaskController;
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

Route::post('/project', [ProjectController::class, 'create']);
Route::patch('/project', [ProjectController::class, 'update']);
Route::get('/project', [ProjectController::class, 'get']);
Route::get('/project/{project}', [ProjectController::class, 'getOneProject']);
Route::delete('/project/{projectId}', [ProjectController::class, 'delete']);

Route::post('/task', [TaskController::class, 'create']);
Route::patch('/task', [TaskController::class, 'update']);
Route::get('/task/{progectId}', [TaskController::class, 'get']);
Route::delete('/task/{taskId}', [TaskController::class, 'delete']);
Route::patch('/task/order', [TaskController::class, 'updateOrderOrStatus']);
Route::patch('/task/status', [TaskController::class, 'updateStatus']);
Route::get('/oneTask/{taskId}', [TaskController::class, 'getOneTask']);

Route::post('/task/{task}/upload', [TaskController::class, 'uploadFile']);
Route::delete('/file/{fileId}', [TaskController::class, 'deleteFile']);


Route::post('/comment', [CommentController::class, 'create']);
Route::get('/comment/{taskId}', [CommentController::class, 'get']);
Route::patch('/comment', [CommentController::class, 'update']);
Route::delete('/comment/{commentId}', [CommentController::class, 'delete']);

Route::patch('/subTask', [SubTaskController::class, 'updateStatus']);
Route::post('/subTask', [SubTaskController::class, 'create']);
Route::delete('/subTask/{subTaskId}', [SubTaskController::class, 'delete']);
