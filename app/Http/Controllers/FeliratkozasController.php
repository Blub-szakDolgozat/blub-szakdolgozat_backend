<?php

namespace App\Http\Controllers;

use App\Models\Esemeny;
use App\Models\Feliratkozas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeliratkozasController extends Controller
{
    // Feliratkozás eseményre
    public function store(Request $request)
    {
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        $felhasznaloId = auth()->id();  // Feltételezzük, hogy a felhasználó be van jelentkezve
        if (!$felhasznaloId) {
            return response()->json(['error' => 'Nem vagy bejelentkezve'], 401); // Nem engedjük feliratkozni, ha nincs bejelentkezve
        }
    
        // Ellenőrizzük, hogy létezik-e a kérésben az esemény ID
        $esemenyId = $request->input('esemeny_id'); // vagy $request->route('id') URL paramétereknél
    
        if (!$esemenyId) {
            return response()->json(['error' => 'Esemény ID nem található'], 400);
        }
    
        // Ellenőrizzük, hogy az esemény létezik-e
        $esemeny = Esemeny::find($esemenyId);
        if (!$esemeny) {
            return response()->json(['error' => 'Esemény nem található'], 404);
        }
    
        // Ellenőrizzük, hogy a felhasználó már feliratkozott-e
        $existingSubscription = Feliratkozas::where('felhasznalo', $felhasznaloId)
                                                ->where('esemeny', $esemenyId)
                                                ->first();
        if ($existingSubscription) {
            return response()->json(['error' => 'Már feliratkoztál erre az eseményre.'], 400);
        }
    
        // Feliratkozás adatainak tárolása
        Feliratkozas::create([
            'felhasznalo' => $felhasznaloId,
            'esemeny' => $esemenyId,
            'feliratkozas_datuma' => now(),
        ]);
    
        // Frissítjük az esemény létszámát
        $esemeny->increment('letszam');
    
        return response()->json(['message' => 'Sikeres feliratkozás!'], 200);
    }
    

    // Feliratkozás törlése
    public function destroy(Request $request, string $esemeny_id)
    {
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        $user = auth()->user(); // Jelenlegi bejelentkezett felhasználó
        if (!$user) {
            return response()->json(['error' => 'Nem vagy bejelentkezve'], 401); // Nem engedjük törölni, ha nincs bejelentkezve
        }

        // Ellenőrizzük, hogy létezik-e a feliratkozás
        $subscription = DB::table('feliratkozas')
            ->where('felhasznalo', $user->id)
            ->where('esemeny', $esemeny_id)
            ->first();

        if (!$subscription) {
            return response()->json(['error' => 'Nem vagy feliratkozva erre az eseményre.'], 404);
        }

        // Töröljük a feliratkozást
        DB::table('feliratkozas')
            ->where('felhasznalo', $user->id)
            ->where('esemeny', $esemeny_id)
            ->delete();

        // Frissítjük az esemény létszámát
        DB::table('esemenyek')
            ->where('esemeny_id', $esemeny_id)
            ->decrement('letszam', 1); // Csökkentjük a létszámot, hiszen a feliratkozás törlődött

        return response()->json(['message' => 'Sikeresen leiratkoztál az eseményről']);
    }

    // Feliratkozott felhasználók egy eseményre
    public function esemenyreFeliratkozottak(string $esemény_id)
    {
        $felhasznalok = DB::table('feliratkozas as f')
            ->join('users as u', 'f.felhasznalo', '=', 'u.azonosito')
            ->select('u.name')
            ->where('f.esemeny', '=', $esemény_id)
            ->get();

        return $felhasznalok;
    }

    // Egy felhasználó összes feliratkozott eseménye
    public function userFeliratkozasai(string $user_id)
    {
        $esemenyek = DB::table('feliratkozas as f')
            ->join('esemenies as e', 'f.esemeny', '=', 'e.esemeny_id')
            ->select('e.esemeny_neve', 'e.datum', 'e.helyszin')
            ->where('f.felhasznalo', '=', $user_id)
            ->get();

        return $esemenyek;
    }
}
