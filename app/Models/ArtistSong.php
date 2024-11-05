<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistSong extends Model
{
    protected $table = 'artist_song';

    protected $fillable = [
        'artist_id','song_id',
    ];
}
