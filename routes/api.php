<?php

use App\Http\Controllers\AkvariumController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::post('/update-username', [UserController::class, 'updateUsername']);
Route::post('/update-email', [UserController::class, 'updateEmail']);
Route::post('/update-profile-pic', [UserController::class, 'updateProfilePic']);
Route::post('/update-password', [UserController::class, 'updatePassword']);
Route::post('/update-user/{user}', [UserController::class, 'update'])->name('update-user');



// Alap lekérdezések --> Cikk
// Cikkeklekérdezése:
Route::get('/cikkek', [CikkController::class, 'index']);

//Új cikk hozzáadása:
Route::post('/cikk-add', [CikkController::class, 'store'])->name('cikk.add.store');

//Cikk id alapján törlése:
Route::delete('/cikk-torol/{cikk_id}', [CikkController::class, 'destroy']);

//Cikk id alapján lekérdezése:
Route::get('/cikk-show/{cikk_id}', [CikkController::class, 'show']);

//Cikk id alapján részlegesen frissítése:
Route::put('/cikkek/{cikk_id}', [CikkController::class, 'put']);
Route::get('/with-example', [VizilenyekController::class, 'withExample']);


// Alap lekérdezések --> Esemény
// Események lekérdezése:
Route::get('/esemenyek', [EsemenyController::class, 'index']);

//Új esemény hozzáadása:
Route::post('/esemeny-add', [EsemenyController::class, 'store']);

//esemény id alapján törlése:
Route::delete('/esemeny-torol/{esemény_id}', [EsemenyController::class, 'destroy']);

//esemény id alapján lekérdezése:
Route::get('/esemeny-show/{esemény_id}', [EsemenyController::class, 'show']);

//esemény id alapján részlegesen frissítése:
Route::put('/esemenyek/{esemény_id}', [EsemenyController::class, 'put']);


// Alap lekérdezések --> Videók
// Videók lekérdezése:
Route::get('/videok', [VideoController::class, 'index']);

//Új videó hozzáadása:
Route::post('/video-add', [VideoController::class, 'store'])->name('videok.add.store');

//videó id alapján törlése:
Route::delete('/video-torol/{video_id}', [VideoController::class, 'destroy']);

//videó id alapján lekérdezése:
Route::get('/video-show/{video_id}', [VideoController::class, 'show']);

//videó id alapján részlegesen frissítése:
Route::put('/videok/{video_id}', [VideoController::class, 'put']);

Route::get('/users', [UserController::class, 'index']);

// Vizi lények CRUD
Route::get('/vizilenyek', [VizilenyekController::class, 'index']);
Route::post('/vizilenyek-add',[VizilenyekController::class, 'store'])->name('vizilenyek.add.store');
Route::get('/vizilenyek-megmutat/{id}',[VizilenyekController::class, 'show']);
Route::put('/vizilenyek/{id}',[VizilenyekController::class, 'update']);
Route::delete('/vizilenyek-torol/{id}',[VizilenyekController::class, 'destroy']);
//akvarium
Route::middleware('auth')->get('user-lenyei', [AkvariumController::class, 'userViziLenyei']);


Route::post('/esemeny/feliratkozas', [FeliratkozasController::class, 'store']);


Route::middleware('auth:sanctum')->delete('/esemeny/{esemeny_id}/feliratkozas', [FeliratkozasController::class, 'destroy']);

// Admin útvonal
Route::middleware(['auth:sanctum', Admin::class])
->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [AuthenticatedSessionController::class, 'store']); 

// Autentikált útvonal, simple user is:
Route::middleware(['auth:sanctum'])
->group(function () {
    // Kijelentkezés útvonal
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

// Lekérdezések
Route::get('videok-hossza', [VideoController::class, 'videokHossza']); 
Route::get('register-order', [UserController::class, 'regisztralasiSorrend']); 
Route::get('ritkasagi-szint', [VizilenyekController::class, 'ritkasagiSzint']);
Route::get('lenyek-csokkeno/{azonosito}', [AkvariumController::class, 'viziLenyekCsokkenoSorrendben']);
Route::get('esemenyre-feliratkozasok/{esemeny_id}', [EsemenyController::class, 'esemenyLetszama']);
Route::get('kik-iratkoztak-fel/{esemeny_id}', [FeliratkozasController::class, 'esemenyreFeliratkozottak']);
Route::get('user-feliratkozasai', [FeliratkozasController::class, 'userFeliratkozasai']);
Route::get('user-lenyei', [AkvariumController::class, 'userViziLenyei']); 


Route::middleware('auth:sanctum')->post('/napi-sorsolas', [VizilenyekController::class, 'napiSorsolas']);
Route::middleware('auth:sanctum')->get('/random-vizi-leny', [VizilenyekController::class, 'randomViziLeny']);
Route::middleware('auth:sanctum')->post('/akvarium/sorsol-hozzaad', [VizilenyekController::class, 'sorsolHozzaad']);
