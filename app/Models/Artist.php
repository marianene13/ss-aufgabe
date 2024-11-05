<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Artist extends Model
{
    use Timestamp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'api_artist_id', 'api_artist_link',
    ];


    public static $rules = [
        'name' => 'required|string|max:255',
        'api_artist_id' => 'required|string',
        'api_artist_link' => 'required|string',
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
