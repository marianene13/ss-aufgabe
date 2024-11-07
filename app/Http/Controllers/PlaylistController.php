<?php

namespace App\Http\Controllers;

use App\Handlers\SpotifyHandler;
use App\Models\Playlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchString = $request->query->get('query');

        $playlists = Playlist::search($searchString)
            ->orderBy('created_at')
            ->where('user_id', Auth::id())
            ->paginate(1);

        return view('playlists.index')
            ->with('playlists', $playlists)
            ->with('searchString', $searchString);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, Request $request)
    {
        $playlist = Playlist::find($id);

        $searchString = $request->query->get('query');

        $songs = $playlist->songs()
            ->where('name', 'like', '%'.$searchString.'%')
            ->paginate(2)
            ->withQueryString('query', $searchString);

        return view('playlists.view')
            ->with('playlist', $playlist)
            ->with('songs', $songs)
            ->with('searchString', $searchString);
    }

    /**
     * Update the specified resource in storage.
     */
    public function removeSong(int $id, int $songId)
    {
        $playlist = Playlist::find($id);
        $playlist->songs()->detach($songId);

        $data['message'] = 'Song deleted successfully!';

        return response()->json($data);
    }

    public function add(SpotifyHandler $handler, Request $request)
    {
        $apiPlaylistId = $request->input('api_playlist_id');
        $playlist = Playlist::where('api_playlist_id', $apiPlaylistId)->get();

        if ($playlist->isEmpty()) {
            $playlist = Playlist::buildFromPlaylistObject($handler->playlist($apiPlaylistId));
            Auth::user()->playlists()->save($playlist);
        }

        return redirect()->route('playlists.index');
    }

    /**
     * @param SpotifyHandler $handler
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loadSongs(SpotifyHandler $handler, int $id): RedirectResponse
    {
        /** @var Playlist $playlist */
        $playlist = Playlist::find($id);

        if ($playlist->songs()->get()->isEmpty()) {
            $playlist->loadSongs($handler);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $playlist = Playlist::find($id);
        $playlist->songs()->detach();
        $playlist->delete();
    }
}
