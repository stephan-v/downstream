<?php

namespace App\Services\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
     * @param string $repository The repository that we want to fetch commits for.
     * @return mixed The decoded response.
     */
    public function getRepositoryCommits(string $repository)
    {
        try {
            $response = $this->client->get("{$repository}/commits/master");
        } catch(ClientException $e) {
            $response = $e->getResponse();
            abort($response->getStatusCode(), $response->getReasonPhrase());
        }

        return json_decode($response->getBody());
    }

    /**
     * Get the webhooks for the specific repository.
     *
     * @param string $repository The repository that we want to fetch webhooks for.
     * @return mixed The decoded response.
     */
    public function getWebhooks(string $repository): ?array
    {
        $response = $this->client->get("{$repository}/hooks");

        return json_decode($response->getBody());
    }

    /**
     * Create the webhook on the specific repository.
     *
     * @param string $repository The repository that we want to create a webhook for.
     * @return object The response.
     */
    public function createWebhook(string $repository)
    {
        $response = $this->client->post("{$repository}/hooks", [
            'json' => [
                'name' => 'web',
                'config' => [
                    'content_type' => 'json',
                    'secret' => env('GITHUB_WEBHOOK_SECRET'),
                    'url' => env('MIX_GITHUB_WEBHOOK_URL')
                ]
            ]
        ]);

        return $response->getBody();
    }

    /**
     * Delete the webhook on the specific repository.
     *
     * @param int $id The id of the webhook to delete.
     * @param string $repository The repository that we want to delete a webhook for.
     * @return null The decoded response.
     */
    public function deleteWebhook($id, $repository)
    {
        $response = $this->client->delete("{$repository}/hooks/{$id}");

        return json_decode($response->getBody());
    }
}
