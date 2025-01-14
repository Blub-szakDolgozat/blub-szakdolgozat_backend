<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[RegisteredUserController::class, 'store']);
Route::post('/login',[AuthenticatedSessionController::class, 'store']);

// Autentikált útvonal, simple user is:
Route::middleware(['auth:sanctum'])
->group(function () {

    // Kijelentkezés útvonal
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});


// Admin útvonal
Route::middleware(['auth:sanctum', Admin::class])
->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
});
