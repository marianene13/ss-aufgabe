<?php

namespace App\Handlers;

use App\Clients\SpotifyClient;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class SpotifyHandler
{
    private const API_URL = 'https://api.spotify.com/v1';

    protected SpotifyClient $client;

    protected string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->client = new SpotifyClient();
    }

    /**
     * @param string $id
     * @return stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function playlist(string $id): stdClass
    {
        $endpoint = sprintf('%s/playlists/%s', self::API_URL, $id);

        $response = $this->client->get($endpoint, $this->buildHeaders());

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $id
     * @return array<stdClass>
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function playlistTracks(string $id): array
    {
        $endpoint = sprintf('%s/playlists/%s/tracks', self::API_URL, $id);

        $acceptedParams = [
            'limit' => null,
            'offset' => null,
        ];

        $response = $this->client->get($endpoint, $this->buildHeaders() + $acceptedParams);

        return $this->handleResponse($response)->items;
    }

    /**
     * @param string $query
     * @return stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchPlaylists(string $query): stdClass
    {
        $endpoint = sprintf('%s/search', self::API_URL);

        $acceptedParams = [
            'q' => $query,
            'type' => 'playlist',
            'limit' => null,
            'offset' => null,
            'include_external' => null,
        ];

        $response = $this->client->get($endpoint, $this->buildHeaders() + $acceptedParams);


        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @return stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function track(string $id): stdClass
    {
        $endpoint = sprintf('%s/tracks/%s', self::API_URL, $id);

        $response = $this->client->get($endpoint, $this->buildHeaders());

        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @return stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function audioFeatures(string $id): stdClass
    {
        $endpoint = sprintf('%s/audio-features/%s', self::API_URL, $id);

        $response = $this->client->get($endpoint, $this->buildHeaders());

        return $this->handleResponse($response);
    }

    protected function handleResponse(ResponseInterface $response): stdClass
    {
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return array<string[]>
     */
    protected function buildHeaders(): array
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accepts' => 'application/json',
                'Authorization' => 'Bearer '.$this->accessToken,
            ]
        ];
    }
}
