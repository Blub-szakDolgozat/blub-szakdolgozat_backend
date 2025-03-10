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
        $validated = $request->validate([
            'esemeny_id' => 'required|integer|exists:esemenies,esemeny_id', // Ha integer, nincs szükség stringre
        ]);
    
        $esemenyId = $validated['esemeny_id'];
        
        // Esemény keresése
        $esemeny = Esemeny::find($esemenyId);
        if (!$esemeny) {
            return response()->json(['error' => 'Esemény nem található'], 404);
        }
    
        // További kód a feliratkozás kezelésére
        $felhasznaloId = Auth::id();  // Feltételezve, hogy a felhasználói azonosítót így szerzed be
    
        // Ellenőrizzük, hogy a felhasználó már feliratkozott-e
       /*  $existingSubscription = Feliratkozas::where('felhasznalo', $felhasznaloId)
                                            ->where('esemeny', $esemenyId)
                                            ->first();
        if ($existingSubscription) {
            return response()->json(['error' => 'Már feliratkoztál erre az eseményre.'], 400);
        }
    */
        // Feliratkozás adatainak tárolása

        DB::table('feliratkozas')->insert([
            'felhasznalo' => $felhasznaloId,
            'esemeny' => $esemenyId,
            'feliratkozas_datuma' => now(),
        ]);

      /* Feliratkozas::factory()->create([
            'felhasznalo' => $felhasznaloId,
            'esemeny' => $esemenyId,
            'feliratkozas_datuma' => now(),
        ]);  */
    
        // Frissítjük az esemény létszámát
       /*  $esemeny->increment('letszam');  */
    
        return response()->json(['message' => 'Sikeres feliratkozás!'], 200); 
/*         return response()->json([ 'felhasznalo' => $felhasznaloId,
        'esemeny' => $esemenyId,
        'feliratkozas_datuma' => now(),], 200); */
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

    // 3. Adott eseményre kik iratkoztak fel
    public function esemenyreFeliratkozottak(string $esemeny_id){

        $felhasznalok = DB::table('feliratkozas as f') ->join('users as u', 'f.felhasznalo', '=', 'u.azonosito') 
        ->select('u.name')
        ->where('f.esemeny', '=', $esemeny_id) 
        ->get();

        return $felhasznalok;
    }

    // Egy felhasználó összes feliratkozott eseménye
    
    // 2. Adott felhasználó milyen eseményekre iratkozott fel
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
