<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    // Alap lekérdezések

        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Video::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Video();
        $record->fill($request->all());
        $record->save();
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

}
