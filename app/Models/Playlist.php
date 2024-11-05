<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Playlist extends Model
{
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

    public function songs(){
        return $this->belongsToMany(Song::class, PlaylistSong::class)->withTimestamps();
    }
}
