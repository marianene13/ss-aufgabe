<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audio_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('song_id')->index();
            $table->float('danceability');
            $table->float('energy');
            $table->integer('key');
            $table->float('loudness');
            $table->integer('mode');
            $table->float('speechiness');
            $table->float('acousticness');
            $table->float('instrumentalness');
            $table->float('liveness');
            $table->float('valence');
            $table->float('tempo');
            $table->string('api_audio_feature_id');
            $table->timestamps();

            $table->foreign('song_id')->references('id')->on('songs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_features');
    }
};
