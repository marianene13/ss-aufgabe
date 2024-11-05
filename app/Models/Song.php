<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Song extends Model
{
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


    public function artists(){
        return $this->belongsToMany(Artist::class, PlaylistSong::class)->withTimestamps();
    }

    public function playlists(){
        return $this->belongsToMany(Playlist::class,PlaylistSong::class)->withTimestamps();
    }
}
