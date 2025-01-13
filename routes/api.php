<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VizilenyekController;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//bárki által elérhető
Route::post('/register',[RegisteredUserController::class, 'store']);
Route::post('/login',[AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//Admin


//Felhasználó

// Vizi lények CRUD
Route::get('/vizilenyek', [VizilenyekController::class, 'index']);
Route::post('/vizilenyekadd',[VizilenyekController::class, 'store']);

Route::post('/vizilenyekMegmutat/{id}',[VizilenyekController::class, 'show']);
Route::put('/vizilenyek/{id}',[VizilenyekController::class, 'put']);
Route::delete('/vizilenyekTorol/{id}',[VizilenyekController::class, 'destroy']);

// lekérezések az alap lékérdezésekken kivül 7-8 db:

// with-es lekérdezések 2-3 db:
Route::get('/vizilenyek-with', [ViziLenyekController::class, 'withExample']);


Route::middleware(['auth:sanctum'])
->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Kijelentkezés útvonal
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', Admin::class])
->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
});
