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
        $files = Cikk::latest()->get();
        return $files;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cim' => 'required',
            'leiras' => 'required',
            'kepek' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $file = $request->file('kep'); 
        $extension = $file->getClientOriginalName(); 
        $imageName = time() . '.' . $extension; 
        $file->move(public_path('kepek'), $imageName);

        $vizileny = new Cikk(); 
        $vizileny->kepek = 'kepek/' . $imageName; 
        $vizileny->cim = $request->cim; 
        $vizileny->publikalva = $request->publikalva; 
        $vizileny->leiras = $request->leiras; 

        $vizileny->save(); 

        return redirect()->route('cikk.add')->with('success', 'Product created successfully.');
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
