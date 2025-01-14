<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

abstract class Controller
{
    // Nem alap Lekérdezések

    // 1. Adott felhasználónak visszaadja az akváriumában lévő vízi lényeket:
    public function userViziLenyei(string $user_id){
        $lenyek = DB::table('akvaria as a')
            ->join('vizilenyeks as v', 'a.vizi_leny_id', '=', 'v.vizi_leny_id')
            ->where('a.felhasznalo_id', '=', $user_id)
            ->get(['v.nev', 'v.fajta', 'v.ritkasagi_szint']);
        
        return $lenyek;
    }

    // 2. Egy felhasználó összes feliratkozott eseménye
    public function userFeliratkozasai(string $user_id)
    {
        $esemenyek = DB::table('feliratkozas as f') ->join('esemenies as e', 'f.esemeny', '=', 'e.esemény_id') 
        ->where('f.felhasznalo', '=', $user_id)
        ->get(['e.esemény_neve', 'e.dátum', 'e.helyszín']);

        return $esemenyek;
    }

    // 3.	Felirakotkozott felhasználók egy eseményre
    public function esemenyreFeliratkozottak(string $esemény_id){

        $felhasznalok = DB::table('feliratkozas as f') ->join('users as u', 'f.felhasznalo', '=', 'u.azonosító') 
        ->where('f.esemeny', '=', $esemény_id) 
        ->get(['u.name']);

        return $felhasznalok;
    }

    // 4. Egy esemény létszámának lekérdezése
    public function esemenyLetszama(string $esemény_id){
        $letszam = DB::table('feliratkozas as f') ->where('esemeny', '=', $esemény_id) 
        ->count();

        return $letszam;
    }

    // 5. Felhasználó akváriumába bekerülő vízi lények csökkenő sorrendben, így az első rekord az lesz, hogy legutóbb melyik vízi lény került be az akváriumba:
    public function viziLenyekCsokkenoSorrendben(string $user_id){
        $lenyek = DB::table('akvaria as a') ->join('vizilenyeks as v', 'a.vizi_leny_id', '=', 'v.vizi_leny_id') 
        ->where('a.felhasznalo_id', '=', $user_id) 
        ->orderByDesc('a.bekerules_ideje') 
        ->get(['v.nev', 'v.fajta', 'a.bekerules_ideje']);

        return $lenyek;
    }

    // 6.	Összes vízi lény a legnagyobb ritkasági szinttel
    public function ritkasagiSzint(){
        $lenyek = DB::table('vizilenyeks') ->orderByDesc('ritkasagi_szint') 
        ->get(['nev', 'fajta', 'ritkasagi_szint']);

        return $lenyek;
    }

    //  7.	Felhasználók regisztrálási sorrendje:
    public function regisztralasiSorrend(){
        $felhasznalok = DB::table('users') 
        ->orderByDesc('regisztracio_datum') 
        ->get(['name', 'email', 'regisztracio_datum']);

        return $felhasznalok;
    }

    // 8. Videók hossza csökkenő sorrendben
    public function videokHossza(){

        $videok = DB::table('videos') 
        ->orderByDesc('hossz')
        ->get(['cim', 'hossz']);        
        
        return $videok;
    }


}
