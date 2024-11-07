<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class Song extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'popularity', 'duration', 'is_playable', 'api_track_id',
    ];


    public static $rules = [
        'name' => 'required|string|max:255',
        'is_playable' => 'required|boolean',
        'api_track_id' => 'required|string',
    ];


    public static $messages = [
        'required' => 'The :attribute field cannot be blank!',
    ];


    public static function validate(array $data){
        return Validator::make($data, static::$rules, static::$messages);
    }


    public function artists()
    {
        return $this->belongsToMany(Artist::class, ArtistSong::class)->withTimestamps();
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class,PlaylistSong::class)->withTimestamps();
    }

    public static function findByTrackObject(\stdClass $track): self
    {
        $song = self::where('api_track_id', $track->id)->get();

        if ($song->isEmpty()) {
            $song = self::createFromTrackObject($track);

            foreach ($track->artists as $artist) {
                $artist = Artist::findByArtistObject($artist);

                $song->artists()->attach($artist);
            }
        }

        return $song;
    }

    public static function createFromTrackObject(\stdClass $track): self
    {
        return self::create([
            'name' => $track->name,
            'popularity' => $track->popularity,
            'duration' => $track->duration_ms,
            'is_playable' => $track->is_playable ?? true,
            'api_track_id' => $track->id,
        ]);
    }

    public function searchableAs(): string
    {
        return 'songs_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingPrefix(['id', 'api_track_id', 'popularity'])]
    #[SearchUsingFullText(['name'])]
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'api_track_id' => $this->api_track_id,
            'popularity' => $this->popularity,
            'name' => $this->name,
        ];
    }
}
