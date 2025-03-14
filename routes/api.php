<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimesheetController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    Route::get('/timesheets', [TimesheetController::class, 'index']);
    Route::post('/timesheets', [TimesheetController::class, 'store']);
    Route::put('/timesheets/{id}', [TimesheetController::class, 'update']);
    Route::delete('/timesheets/{id}', [TimesheetController::class, 'destroy']);

});