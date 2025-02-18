<?php

namespace App\Http\Controllers;

use App\Models\Akvarium;
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
            ->select('v.nev', 'v.fajta', 'v.ritkasagi_szint')
            ->where('a.felhasznalo_id', '=', $user_id)
            ->get();
        
        return $lenyek;
    }
}
