<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VizilenyekController;
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

// Vizi lények CRUD
Route::get('/vizilenyek', [VizilenyekController::class, 'index']);
Route::post('/vizilenyekAdd',[VizilenyekController::class, 'store']);
Route::post('/vizilenyekMegmutat/{id}',[VizilenyekController::class, 'show']);
Route::put('/vizilenyek/{id}',[VizilenyekController::class, 'put']);
Route::delete('/vizilenyekTorol/{id}',[VizilenyekController::class, 'destroy']);

// Admin útvonal
Route::middleware(['auth:sanctum', Admin::class])
->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
});
