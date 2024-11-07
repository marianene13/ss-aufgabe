<?php

namespace App\Providers;

use App\Handlers\SpotifyAuthHandler;
use App\Handlers\SpotifyHandler;
use Illuminate\Support\ServiceProvider;

class SpotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SpotifyAuthHandler::class, function () {
            $clientId = config('spotify.auth.client_id');
            $clientSecret = config('spotify.auth.client_secret');

            return new SpotifyAuthHandler($clientId, $clientSecret);
        });

        $this->app->bind(SpotifyHandler::class, function () {
            $accessToken = $this->app->make(SpotifyAuthHandler::class)->getAccessToken();

            return new SpotifyHandler($accessToken);
        });
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/spotify.php', 'spotify');

        $this->publishes([
            __DIR__.'/../../config/spotify.php' => config_path('spotify.php'),
        ]);
    }
}
