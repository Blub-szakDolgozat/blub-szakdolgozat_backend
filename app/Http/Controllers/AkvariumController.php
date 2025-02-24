<?php

namespace App\Http\Controllers;

use App\Models\Akvarium;
use App\Models\Vizilenyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AkvariumController extends Controller
{

    // 5. Adott felhasználó akváriumába bekerülő vízi lények időrendi sorrendben
    public function viziLenyekCsokkenoSorrendben(string $user_id){
        $lenyek = DB::table('akvaria as a') ->join('vizilenyeks as v', 'a.vizi_leny_id', '=', 'v.vizi_leny_id') 
        ->where('a.felhasznalo_id', '=', $user_id) 
        ->select('v.nev', 'v.fajta', 'a.bekerules_ideje')
        ->orderByDesc('a.bekerules_ideje') 
        ->get();

        return $lenyek;
    }

        // Nem alap Lekérdezések

    // 1. Bejelentkezett felhasználónak visszaadja az akváriumában lévő vízi lényeket:
    public function napiSorsolas()
    {
        $user = Auth::user();
        $ma = now()->toDateString(); // A mai dátum
    
        // Ellenőrizzük, hogy a felhasználó már kapott-e aznap vízi lényt
        $kapottMarMa = Akvarium::where('felhasznalo_id', $user->id)
            ->whereDate('bekerules_ideje', $ma)
            ->exists();
    
        if ($kapottMarMa) {
            return response()->json(['message' => 'Már kaptál vízi lényt ma!'], 409);
        }
    
        // Véletlenszerű vízi lény kiválasztása
        $viziLeny = Vizilenyek::inRandomOrder()->first();
    
        if (!$viziLeny) {
            return response()->json(['message' => 'Nincs elérhető vízi lény.'], 404);
        }
    
        // Hozzáadás az akváriumhoz
        $akvarium = new Akvarium();
        $akvarium->felhasznalo_id = $user->id;
        $akvarium->vizi_leny_id = $viziLeny->vizi_leny_id;
        $akvarium->bekerules_ideje = now();
        $akvarium->save();
    
        return response()->json([
            'message' => 'Sikeres napi sorsolás!',
            'vizi_leny' => $viziLeny
        ]);
    }
}    