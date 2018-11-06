<?php

namespace App\Domain\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

/**
 * The GithubClient configures and provide a Guzzle HTTP client for Github API requests.
 */
class GithubClient
{
    /**
     * The Github configured Guzzle HTTP client.
     *
     * @var Client $client
     */
    private $client;

    /**
     * GithubClient constructor.
     *
     * @param Client $client The base Guzzle client with Github configuration.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a  list of commits on a repository.
     *
     * @return mixed The decoded response.
     */
    public function getCommits()
    {
        $response = $this->client->get('beerquest/commits/master');

        return json_decode($response->getBody());
    }

    /**
     * Set the webhook on the specific repository.
     *
     * @return mixed The decoded response.
     */
    public function setWebhook(): Response
    {
        try {
            $response = $this->client->post('beerquest/hooks', [
                'json' => [
                    'name' => 'web',
                    'config' => [
                        'url' => env('APP_URL') . '/webhook',
                        'content_type' => 'json'
                    ]
                ]
            ]);
        } catch(ClientException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }
}
