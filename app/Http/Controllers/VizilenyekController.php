<?php

namespace App\Http\Controllers;

use App\Models\Vizilenyek;
use Illuminate\Http\Request;

class VizilenyekController extends Controller
{
    public function index()
    {
        return Vizilenyek::all();
    }
    public function store(Request $request){
        $record= new Vizilenyek();
        $record->fill($request->all());
        $record->save();
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
