<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimesheetController;
use App\Http\Controllers\Api\AttributeController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('project')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/{id}', [ProjectController::class, 'getProjectById']);
        Route::post('/', [ProjectController::class, 'addProject']);
        Route::put('/{id}', [ProjectController::class, 'updateProject']);
        Route::delete('/{id}', [ProjectController::class, 'deleteProject']);
    });

    Route::prefix('timesheet')->group(function () {
        Route::get('/', [TimesheetController::class, 'index']);
        Route::get('/{id}', [TimesheetController::class, 'getTimesheetById']);
        Route::post('/', [TimesheetController::class, 'addTimesheet']);
        Route::put('/{id}', [TimesheetController::class, 'updateTimesheet']);
        Route::delete('/{id}', [TimesheetController::class, 'deleteTimesheet']);
    });

    Route::prefix('attribute')->group(function () {
        Route::get('/', [AttributeController::class, 'index']);
        Route::get('/{id}', [AttributeController::class, 'getAttributeById']);
        Route::post('/', [AttributeController::class, 'addAttribute']);
        Route::put('/{id}', [AttributeController::class, 'updateAttribute']);
        Route::delete('/{id}', [AttributeController::class, 'deleteAttribute']);
    });
});