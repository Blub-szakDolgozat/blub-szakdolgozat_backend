<?php

namespace App\Http\Controllers;

use App\Models\Akvarium;
use App\Models\Vizilenyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AkvariumController extends Controller
{

    // 5. Felhasználó akváriumába bekerülő vízi lények csökkenő sorrendben, így az első rekord az lesz, hogy legutóbb melyik vízi lény került be az akváriumba:
    public function viziLenyekCsokkenoSorrendben(string $user_id){
        $lenyek = DB::table('akvaria as a') ->join('vizilenyeks as v', 'a.vizi_leny_id', '=', 'v.vizi_leny_id') 
        ->where('a.felhasznalo_id', '=', $user_id) 
        ->select('v.nev', 'v.fajta', 'a.bekerules_ideje')
        ->orderByDesc('a.bekerules_ideje') 
        ->get();

        return $lenyek;
    }

        // Nem alap Lekérdezések

    // 1. Adott felhasználónak visszaadja az akváriumában lévő vízi lényeket:
    public function userViziLenyei(string $user_id){
        $lenyek = DB::table('akvaria as a')
            ->join('vizilenyeks as v', 'a.vizi_leny_id', '=', 'v.vizi_leny_id')
            ->select('v.nev', 'v.fajta', 'v.ritkasagi_szint')
            ->where('a.felhasznalo_id', '=', $user_id)
            ->get();
        
        return $lenyek;
    }
    // 2. Véletlenszerű vízi lény lekérése
    public function randomViziLeny()
    {
        $viziLeny = Vizilenyek::inRandomOrder()->first();

        if (!$viziLeny) {
            return response()->json(['message' => 'Nincs elérhető vízi lény.'], 404);
        }

        return response()->json($viziLeny);
    }

    // 3. Sorsolt vízi lény hozzáadása a felhasználó akváriumához
    public function hozzaadAkvariumhoz(Request $request)
    {
        $user = Auth::user();
        $vizi_leny_id = $request->input('vizi_leny_id');

        // Ellenőrzés: létezik-e már a felhasználó akváriumában ez a lény?
        $lehetMarVan = Akvarium::where('felhasznalo_id', $user->id)
            ->where('vizi_leny_id', $vizi_leny_id)
            ->exists();

        if ($lehetMarVan) {
            return response()->json(['message' => 'Ez a vízi lény már az akváriumban van!'], 409);
        }

        // Ha nincs, mentjük
        $akvarium = new Akvarium();
        $akvarium->felhasznalo_id = $user->id;
        $akvarium->vizi_leny_id = $vizi_leny_id;
        $akvarium->bekerules_ideje = now();
        $akvarium->save();

        return response()->json(['message' => 'Sikeresen hozzáadva az akváriumhoz!']);
    }

}
