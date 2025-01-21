<?php

namespace App\Http\Controllers;

use App\Models\Feliratkozas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeliratkozasController extends Controller
{
    
    // 3.	Felirakotkozott felhasználók egy eseményre
    public function esemenyreFeliratkozottak(string $esemény_id){

        $felhasznalok = DB::table('feliratkozas as f') ->join('users as u', 'f.felhasznalo', '=', 'u.azonosító') 
        ->select('u.name')
        ->where('f.esemeny', '=', $esemény_id) 
        ->get();

        return $felhasznalok;
    }

    
    // 2. Egy felhasználó összes feliratkozott eseménye
    public function userFeliratkozasai(string $user_id)
    {
        $esemenyek = DB::table('feliratkozas as f') ->join('esemenies as e', 'f.esemeny', '=', 'e.esemeny_id') 
        ->select('e.esemeny_neve', 'e.datum', 'e.helyszin')
        ->where('f.felhasznalo', '=', $user_id)
        ->get();

        return $esemenyek;
    }
}
