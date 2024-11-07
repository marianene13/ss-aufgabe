<?php

namespace App\Handlers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use App\Clients\SpotifyClient;

class SpotifyAuthHandler
{
    private const SPOTIFY_AUTH_TOKEN_URL = 'https://accounts.spotify.com/api/token';

    private $clientId;

    private $clientSecret;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Generate the access token that will be used to make request to the Spotify API.
     *
     * @throws RequestException
     */
    private function generateAccessToken(): void
    {
        $client = new SpotifyClient();

        $response = $client->post(self::SPOTIFY_AUTH_TOKEN_URL, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accepts' => 'application/json',
                'Authorization' => 'Basic '.base64_encode($this->clientId.':'.$this->clientSecret),
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $body = json_decode((string) $response->getBody());

        Cache::remember('spotifyAccessToken', $body->expires_in, function () use ($body) {
            return $body->access_token;
        });
    }

    /**
     * Get the access token.
     *
     * @throws RequestException
     */
    public function getAccessToken(): string
    {
        if (! Cache::has('spotifyAccessToken')) {
            $this->generateAccessToken();
        }

        return Cache::get('spotifyAccessToken');
    }
}
