<?php

namespace App\Http\Controllers;

use App\Models\Vizilenyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VizilenyekController extends Controller
{
    public function index()
    {
        $files = Vizilenyek::latest()->get();
        return $files;
    }
    public function store(Request $request){
        $request->validate([
            'nev' => 'required',
            'fajta' => 'required',
            'ritkasagi_szint' => 'required',
            'leiras' => 'required',
            'kep' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $file = $request->file('kep'); 
        $extension = $file->getClientOriginalName(); 
        $imageName = time() . '.' . $extension; 
        $file->move(public_path('kepek'), $imageName); 

        $vizileny = new Vizilenyek(); 
        $vizileny->kep = 'kepek/' . $imageName; 
        $vizileny->nev = $request->nev; 
        $vizileny->fajta = $request->fajta; 
        $vizileny->ritkasagi_szint = $request->ritkasagi_szint;
        $vizileny->leiras = $request->leiras; 

        $vizileny->save(); 

        return redirect()->route('vizilenyek.add')->with('success', 'Product created successfully.');
    }
    
    public function show(string $id){
        $doga=Vizilenyek::where('id', $id)->get();
        return $doga;
    }
    
    public function update(Request $request, string $id){
        $record=Vizilenyek::find($id);
        $record->fill($request->all());
        $record->save();
    }
    public function destroy($id){
        Vizilenyek::find($id)->delete();
    }

    public function withExample()
    {
        $viziLenyek = ViziLenyek::with('akvariumok')  
            ->where('ritkasagi_szint', '⭐')           
            ->get();                                 

        return response()->json([
            'data' => $viziLenyek
        ]);
    }
    
    // 6.	Összes vízi lény a legnagyobb ritkasági szinttel
    public function ritkasagiSzint(){
        $lenyek = DB::table('vizilenyeks') ->orderByDesc('ritkasagi_szint') 
        ->select('nev', 'fajta', 'ritkasagi_szint')
        ->get();

        return $lenyek;
    }

    public function randomViziLeny(){
        $random = Vizilenyek::inRandomOrder()->first(); 

        return response()->json([
        'data' => $random
        ]);
    }

    public function sorsolHozzaad()
    {
        // Get a random water creature from the Vizilenyek table
        $randomViziLeny = Vizilenyek::inRandomOrder()->first();
    
        if ($randomViziLeny) {
            // Get the current user's ID (assuming user is authenticated)
            $userId = auth()->user()->azonosito;
    
            // Add the random water creature to the akvarium table
            DB::table('akvaria')->insert([
                'felhasznalo_id' => $userId,
                'vizi_leny_id' => $randomViziLeny->vizi_leny_id,
                'bekerules_ideje' => now(),
            ]);
    
            // Return a success response with the added water creature
            return response()->json([
                'message' => 'Random water creature added to aquarium.',
                'vizi_leny' => $randomViziLeny,
            ]);
        }
    
        // If no water creature was found
        return response()->json([
            'message' => 'No water creature found.',
        ], 404);
    }
    
}
