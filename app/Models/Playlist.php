<?php

namespace App\Models;

use App\Handlers\SpotifyHandler;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class Playlist extends Model
{
    use Searchable;
    use Timestamp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'image_url', 'api_playlist_id', 'api_link', 'api_link_songs',
    ];


    public static $rules = [
        'name' => 'required|string|max:255',
        'api_playlist_id' => 'required|string',
        'api_link' => 'required|string',
        'api_link_songs' => 'required|string',
    ];


    public static $messages = [
        'required' => 'The :attribute field cannot be blank!',
    ];


    public static function validate(array $data){
        return Validator::make($data, static::$rules, static::$messages);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, PlaylistSong::class)->withTimestamps();
    }

    public function loadSongs(SpotifyHandler $handler)
    {
        $songs = $this->songs();

        if ($songs->get()->isNotEmpty()) {
            return $songs;
        }

        DB::beginTransaction();

        $items = $handler->playlistTracks($this->api_playlist_id);

        foreach ($items as $item) {
            $song = Song::findByTrackObject($item->track);

            $this->songs()->attach($song);
        }

        DB::commit();

        return $this->songs();
    }

    public static function createFromPlaylistObject(\stdClass $playlist): self
    {
        return self::create([
            'name' => $playlist->name,
            'description' => $playlist->description,
            'image_url' => $playlist->images[0]->url,
            'api_playlist_id' => $playlist->id,
            'api_link' => $playlist->href,
            'api_link_songs' => $playlist->tracks->href,
        ]);
    }

    public function searchableAs(): string
    {
        return 'playlists_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingPrefix(['id', 'api_playlist_id', 'api_link'])]
    #[SearchUsingFullText(['name'])]
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'api_playlist_id' => $this->api_playlist_id,
            'api_link' => $this->api_link,
            'name' => $this->name,
        ];
    }
}
