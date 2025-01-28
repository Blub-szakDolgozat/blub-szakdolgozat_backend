<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    // Alap lekérdezések

        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = Video::latest()->get();
        return $files;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cim' => 'required',
            'link' => 'required',
            'hossz' => 'required',
            'nyitokep' =>  'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $file = $request->file('nyitokep'); 
        $extension = $file->getClientOriginalName(); 
        $imageName = time() . '.' . $extension; 
        $file->move(public_path('kepek'), $imageName); 

        $video = new Video(); 
        $video->nyitokep = 'kepek/' . $imageName; 
        $video->cim = $request->cim; 
        $video->link = $request->link; 
        $video->hossz = $request->hossz;

        $video->save(); 

        return redirect()->route('videok.add')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = Video::where('video_id', $id)
        ->get();
        return $video;
    }

    /**
     * Update the specified resource in storage.
     */
    public function put(Request $request, string $id)
    {
        $record = Video::find($id);
        $record -> fill($request ->all());
        $record ->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Video::find($id)->delete();
    }

    
    // 8. Videók hossza csökkenő sorrendben
    public function videokHossza(){
        $videok = DB::table('videos') 
        ->select('cim', 'hossz')
        ->orderByDesc('hossz')
        ->get();        
        
        return $videok;
    }
    
}
