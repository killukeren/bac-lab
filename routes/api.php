<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\groupController;
use App\Http\Controllers\messageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/groups/{id}/messages', [messageController::class, 'index']);
    Route::post('/groups/{id}/messages', [messageController::class, 'store']);

    // All role
    Route::get('/profile/{id}', [UserController::class, 'profile']);
    Route::put('/profile/{id}', [UserController::class, 'update']);
    Route::get('/users/all', [UserController::class, 'showall']);
    Route::get('/users/{id}', [UserController::class, 'getall']);


    // Admin & Superadmin
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
    });

    // Superadmin only
    Route::middleware('role:superadmin')->group(function () {
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::put('/users/{id}/role', [UserController::class, 'updateRole']);
    });

    Route::get('/groups', [groupController::class, 'index']);
    Route::get('/groups/all', [groupController::class, 'all']);
    Route::get('/groups/{id}', [groupController::class, 'show']);
    Route::get('/groups/{id}', [groupController::class, 'show']);
    Route::post('/groups/{id}/join', [groupController::class, 'join']);

    // Admin & superadmin only
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::post('/groups', [groupController::class, 'store']);
        Route::get('/groups/all', [groupController::class, 'all']);
        Route::delete('/groups/{id}/kick', [groupController::class, 'leave']);
    });
});
