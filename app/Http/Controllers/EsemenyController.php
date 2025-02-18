<?php

namespace App\Http\Controllers;

use App\Models\Esemeny;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EsemenyController extends Controller
{
    // Alap lekérdezések

        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Esemeny::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Esemeny();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $esemeny = Esemeny::where('esemeny_id', $id)
        ->get();
        return $esemeny;
    }

    /**
     * Update the specified resource in storage.
     */
    public function put(Request $request, string $id)
    {
        $record = Esemeny::find($id);
        $record -> fill($request ->all());
        $record ->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Esemeny::find($id)->delete();
    }

    
    // 4. Adott eseményre való feliratkozások számának lekérdezése
    public function esemenyLetszama(string $esemeny_id){
        $letszam = DB::table('feliratkozas as f') ->where('esemeny', '=', $esemeny_id) 
        ->count();

        return $letszam;
    }

}
