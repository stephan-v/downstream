<?php

namespace App\Domain\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

/**
 * The GithubClient configures and provide a Guzzle HTTP client for Github API requests.
 */
class GithubClient implements VersionControlInterface
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
        try {
            $response = $this->client->get('beerquest/commits/master');
        } catch(ClientException $e) {
            $response = $e->getResponse();
        }

        return json_decode($response->getBody());
    }

    /**
     * Get the webhooks for the specific repository.
     *
     * @return mixed The decoded response.
     */
    public function getWebhooks(): Response
    {
        try {
            $response = $this->client->get('beerquest/hooks');
        } catch(ClientException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    /**
     * Create the webhook on the specific repository.
     *
     * @return Response The decoded response.
     */
    public function createWebhook(): Response
    {
        try {
            $response = $this->client->post('beerquest/hooks', [
                'json' => [
                    'name' => 'web',
                    'config' => [
                        'url' => env('MIX_GITHUB_WEBHOOK_URL'),
                        'content_type' => 'json'
                    ]
                ]
            ]);
        } catch(ClientException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    /**
     * Delete the webhook on the specific repository.
     *
     * @param int $id The id of the webhook to delete.
     * @return Response The decoded response.
     */
    public function deleteWebhook($id): Response
    {
        try {
            $response = $this->client->delete("beerquest/hooks/{$id}");
        } catch(ClientException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }
}
