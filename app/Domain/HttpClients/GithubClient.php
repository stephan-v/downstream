<?php

namespace App\Domain\HttpClients;

use GuzzleHttp\Client;

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
     * @return mixed
     */
    public function getCommits()
    {
        $response = $this->client->get('/repos/stephan-v/beerquest/commits/master');

        return json_decode($response->getBody());
    }
}
