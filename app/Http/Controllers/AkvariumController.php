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
    public function userViziLenyei(){
        $user_id=Auth::id();
        $lenyek = DB::table('akvaria as a')
            ->join('vizilenyeks as v', 'a.vizi_leny_id', '=', 'v.vizi_leny_id')
            ->select('v.nev', 'v.fajta', 'v.ritkasagi_szint','v.leiras','v.kep')
            ->where('a.felhasznalo_id', '=', $user_id)
            ->get();
        
        return $lenyek;
    }

    public function randomViziLeny(){
    $user_id = Auth::id();

    // felhasználó akváriumában lévő lények azonosítói
    $userLenyek = DB::table('akvaria')
                    ->where('felhasznalo_id', $user_id)
                    ->pluck('vizi_leny_id')
                    ->toArray();

    // Olyan lényt választ, ami még nincs az akváriumban
    $random = Vizilenyek::whereNotIn('vizi_leny_id', $userLenyek)
                        ->inRandomOrder()
                        ->first();

    if ($random) {
        return response()->json([
            'data' => $random
        ]);
    } else {
        return response()->json([
            'message' => 'Nincs több elérhető lény.'
        ], 404);
    }
    }

    public function sorsolHozzaad(Request $request)
    {
        // bejelentkezett fh azonosítójának lekérdezése
            $userId = auth()->user()->azonosito;
    
            // megnézi, hogy az adott lény benne van-e már az adott fh akváriumában
            $existsInAquarium = DB::table('akvaria')
                ->where('felhasznalo_id', $userId)
                ->where('vizi_leny_id', $request->vizi_leny_id)
                ->exists(); // ellenőrzi, hogy létezik e a rekord
    
                // ha nem létezik, akkor hozzáadjuk a fh akváriumához
            if (!$existsInAquarium) {
                DB::table('akvaria')->insert([
                    'felhasznalo_id' => $userId,
                    'vizi_leny_id' => $request->vizi_leny_id,
                    'bekerules_ideje' => now(),
                ]);
                return response()->json([
                    'message' => 'Vízi lény hozzáadva az akváriumhoz',
                    'vizi_leny' => Akvarium::all(),
                ]);

                // ha létezik, akkor ezt az üzenetet adja vissza
            } else {
                return response()->json([
                    'message' => 'Ez a vízi lény már benne van az akváriumodban',
                ]);
        }
    }

    public function napiSorsolas()
    {
        // bejelentkezett felhasználó: 
        $user = Auth::user();
        $ma = now()->toDateString(); // mai dátum
        
        // felhasználó már kapott-e aznapra vízi lényt
        $kapottMarMa = Akvarium::where('felhasznalo_id', $user->id)
            ->whereDate('bekerules_ideje', $ma)
            ->exists();
        
        if ($kapottMarMa) {
            return response()->json(['message' => 'Már kaptál vízi lényt ma!'], 409);
        }
    
        // random vízi lény sorsolás és ellenőrzés, hogy nincs-e már ilyen a felhasználónak
        $viziLeny = null;
        
        // sorsolás újrapróbálásához, ha már van ilyen vízi lény az akváriumban
        do {
            $viziLeny = Vizilenyek::inRandomOrder()->first();
    
            if (!$viziLeny) {
                return response()->json(['message' => 'Nincs elérhető vízi lény.'], 404);
            }
    
            // felhasználónak már van-e ilyen vízi lény az akváriumában
            $marVan = Akvarium::where('felhasznalo_id', $user->id)
                ->where('vizi_leny_id', $viziLeny->vizi_leny_id)
                ->exists();
    
        } while ($marVan); // ha már van ilyen, újra próbáljuk
    
        // hozzáadás az akváriumhoz
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