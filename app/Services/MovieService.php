<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MovieService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('omdb.base_url'),
            'verify' => false,
        ]);
        $this->apiKey = config('omdb.api_key');
    }

    public function search($query, $page = 1)
    {
        try {
            $response = $this->client->get('', [
                'query' => [
                    's' => $query,
                    'page' => $page,
                    'apikey' => $this->apiKey,
                ],
            ]);
            $data = json_decode($response->getBody(), true);

            if (isset($data['Response']) && $data['Response'] === 'True') {
                return [
                    'movies' => $data['Search'],
                    'total' => $data['totalResults'] ?? 0,
                    'error' => null,
                ];
            }

            return [
                'movies' => [],
                'total' => 0,
                'error' => $data['Error'] ?? trans('messages.movie_not_found'),
            ];
        } catch (\Exception $e) {
            Log::error('OMDB API Error: ' . $e->getMessage());

            return [
                'movies' => [],
                'total' => 0,
                'error' => trans('messages.api_connection_error'),
            ];
        }
    }

    public function getDetail($imdbId)
    {
        try {
            $response = $this->client->get('', [
                'query' => [
                    'i' => $imdbId,
                    'apikey' => $this->apiKey,
                    'plot' => 'full' // Mengambil plot/sinopsis secara penuh
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('OMDB API Error Detail: ' . $e->getMessage());

            return [
                'Response' => 'False',
                'Error' => trans('messages.api_connection_error'),
            ];
        }
    }
}
