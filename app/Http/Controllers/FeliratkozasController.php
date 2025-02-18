<?php

namespace App\Http\Controllers;

use App\Models\Feliratkozas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeliratkozasController extends Controller
{
    
    // 3. Adott eseményre kik iratkoztak fel
    public function esemenyreFeliratkozottak(string $esemeny_id){

        $felhasznalok = DB::table('feliratkozas as f') ->join('users as u', 'f.felhasznalo', '=', 'u.azonosito') 
        ->select('u.name')
        ->where('f.esemeny', '=', $esemeny_id) 
        ->get();

        return $felhasznalok;
    }

    
    // 2. Adott felhasználó milyen eseményekre iratkozott fel
    public function userFeliratkozasai(string $user_id)
    {
        $esemenyek = DB::table('feliratkozas as f') ->join('esemenies as e', 'f.esemeny', '=', 'e.esemeny_id') 
        ->select('e.esemeny_neve', 'e.datum', 'e.helyszin')
        ->where('f.felhasznalo', '=', $user_id)
        ->get();

        return $esemenyek;
    }
}
