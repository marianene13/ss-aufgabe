<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchString = $request->query->get('query');
        $songs = Song::search($searchString)
            ->orderBy('created_at');

        return view('songs.index')
            ->with('songs', $songs->paginate(3))
            ->with('searchString', $searchString ?? null);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $song = Song::find($id);

        return view('songs.view')
            ->with('pageTitle', 'View - '.ucwords($song->name))
            ->with('pageID', 'songs')
            ->with('song', $song)
            ->with('audioFeatures', $song->audioFeatures()->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        //
    }

}
