<?php

use App\Http\Controllers\AkvariumController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CikkController;
use App\Http\Controllers\EsemenyController;
use App\Http\Controllers\FeliratkozasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VizilenyekController;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});

Route::middleware(['auth:sanctum'])
     ->get('/users', [UserController::class, 'index']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
        return $request->user();
});


Route::middleware('auth:sanctum')->post('/update-user/{user}', [UserController::class, 'update'])->name('update-user');
Route::middleware('auth:sanctum')->get('/get-user/{id}', [UserController::class, 'getUser']);
Route::middleware('auth:sanctum')->post('/update-password', [UserController::class, 'updatePassword']);



// Alap lekérdezések --> Cikk
// Cikkeklekérdezése:
Route::get('/cikkek', [CikkController::class, 'index']);

//Cikk id alapján lekérdezése:
Route::get('/cikk-show/{cikk_id}', [CikkController::class, 'show']);


Route::get('/with-example', [VizilenyekController::class, 'withExample']);


// Alap lekérdezések --> Esemény
// Események lekérdezése:
Route::get('/esemenyek', [EsemenyController::class, 'index']);


//esemény id alapján lekérdezése:
Route::get('/esemeny-show/{esemény_id}', [EsemenyController::class, 'show']);

//esemény id alapján részlegesen frissítése:
Route::put('/esemenyek/{esemény_id}', [EsemenyController::class, 'put']);


// Alap lekérdezések --> Videók
// Videók lekérdezése:
Route::get('/videok', [VideoController::class, 'index']);

//videó id alapján lekérdezése:
Route::get('/video-show/{video_id}', [VideoController::class, 'show']);

Route::get('/users', [UserController::class, 'index']);

// Vizi lények CRUD
Route::get('/vizilenyek', [VizilenyekController::class, 'index']);
Route::get('/vizilenyek-megmutat/{id}',[VizilenyekController::class, 'show']);

//akvarium
Route::middleware('auth')->get('user-lenyei', [AkvariumController::class, 'userViziLenyei']);

Route::post('/esemeny/feliratkozas', [FeliratkozasController::class, 'store']);

Route::middleware('auth:sanctum')->delete('/esemeny/{esemeny_id}/feliratkozas', [FeliratkozasController::class, 'destroy']);

// Admin útvonal
Route::middleware(['auth:sanctum', Admin::class])
->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);

    //Új esemény hozzáadása:
    Route::post('/esemeny-add', [EsemenyController::class, 'store']);

    //Új cikk hozzáadása:
    Route::post('/cikk-add', [CikkController::class, 'store'])->name('cikk.add.store');

    //Cikk id alapján törlése:
    Route::delete('/cikk-torol/{cikk_id}', [CikkController::class, 'destroy']);
        
    //Új videó hozzáadása:
    Route::post('/video-add', [VideoController::class, 'store'])->name('videok.add.store');

    //esemény id alapján törlése:
    Route::delete('/esemeny-torol/{esemény_id}', [EsemenyController::class, 'destroy']);
    Route::post('/vizilenyek-add',[VizilenyekController::class, 'store'])->name('vizilenyek.add.store');
    Route::put('/vizilenyek/{id}',[VizilenyekController::class, 'update']);
    Route::delete('/vizilenyek-torol/{id}',[VizilenyekController::class, 'destroy']);

    //Cikk id alapján részlegesen frissítése:
    Route::put('/cikkek/{cikk_id}', [CikkController::class, 'put']);
        
    //videó id alapján törlése:
    Route::delete('/video-torol/{video_id}', [VideoController::class, 'destroy']);

    //videó id alapján részlegesen frissítése:
    Route::put('/videok/{video_id}', [VideoController::class, 'put']);
    
    // Lekérdezések
    Route::get('videok-hossza', [VideoController::class, 'videokHossza']); 
    Route::get('register-order', [UserController::class, 'regisztralasiSorrend']); 
    Route::get('ritkasagi-szint', [VizilenyekController::class, 'ritkasagiSzint']);
    Route::get('lenyek-csokkeno/{azonosito}', [AkvariumController::class, 'viziLenyekCsokkenoSorrendben']);
    Route::get('esemenyre-feliratkozasok/{esemeny_id}', [EsemenyController::class, 'esemenyLetszama']);
    Route::get('kik-iratkoztak-fel/{esemeny_id}', [FeliratkozasController::class, 'esemenyreFeliratkozottak']);
    Route::get('user-feliratkozasai', [FeliratkozasController::class, 'userFeliratkozasai']);
});
Route::get('user-lenyei', [AkvariumController::class, 'userViziLenyei']); 

Route::post('register', [UserController::class, 'register']);
Route::post('login', [AuthenticatedSessionController::class, 'store']); 

// Autentikált útvonal, simple user is:
Route::middleware(['auth:sanctum'])
->group(function () {
    // Kijelentkezés útvonal
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);


Route::middleware('auth:sanctum')->post('/napi-sorsolas', [AkvariumController::class, 'napiSorsolas']);
Route::middleware('auth:sanctum')->get('/random-vizi-leny', [AkvariumController::class, 'randomViziLeny']);
Route::middleware('auth:sanctum')->post('/akvarium/sorsol-hozzaad', [AkvariumController::class, 'sorsolHozzaad']);
