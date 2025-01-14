<?php

namespace App\Http\Controllers;

use App\Models\Cikk;
use Illuminate\Http\Request;

class CikkController extends Controller
{
     // Alap lekérdezések

        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cikk::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Cikk();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cikk = Cikk::where('cikk_id', $id)
        ->get();
        return $cikk;
    }

    /**
     * Update the specified resource in storage.
     */
    public function put(Request $request, string $id)
    {
        $record = Cikk::find($id);
        $record -> fill($request ->all());
        $record ->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Cikk::find($id)->delete();
    }
}
