<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioFeature extends Model
{
    use Timestamp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'danceability', 'energy', 'key', 'loudness', 'mode', 'speechiness', 'acousticness', 'instrumentalness', 'liveness', 'valence', 'tempo', 'api_audio_feature_id',
    ];


    public static $rules = [
        'danceability' => 'required|float',
        'energy' => 'required|float',
        'key' => 'required|int',
        'loudness' => 'required|float',
        'mode' => 'required|int',
        'speechiness' => 'required|float',
        'acousticness' => 'required|float',
        'instrumentalness' => 'required|float',
        'liveness' => 'required|float',
        'valence' => 'required|float',
        'tempo' => 'required|float',
        'api_audio_feature_id' => 'required|string',
    ];


    public static $messages = [
        'required' => 'The :attribute field cannot be blank!',
    ];

    public static function buildFromAudioFeatureObject(\stdClass $audioFeature): self
    {
        return new self([
            'danceability' => $audioFeature->danceability,
            'energy' => $audioFeature->energy,
            'key' => $audioFeature->key,
            'loudness' => $audioFeature->loudness,
            'mode' => $audioFeature->mode,
            'speechiness' => $audioFeature->speechiness,
            'acousticness' => $audioFeature->acousticness,
            'instrumentalness' => $audioFeature->instrumentalness,
            'liveness' => $audioFeature->liveness,
            'valence' => $audioFeature->valence,
            'tempo' => $audioFeature->tempo,
            'api_audio_feature_id' => $audioFeature->id,
        ]);
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }
}
