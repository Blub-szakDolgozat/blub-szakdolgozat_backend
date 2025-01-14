<?php

namespace App\Http\Controllers;

use App\Models\Vizilenyek;
use Illuminate\Http\Request;

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
    
    public function put(Request $request, string $id){
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
}
