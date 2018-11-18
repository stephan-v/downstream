<?php

namespace App\Domain\HttpClients;

use GuzzleHttp\Psr7\Response;

interface VersionControlInterface
{
    /**
     * Get a  list of commits on a repository.
     *
     * @param string $repository The repository that we want to fetch commits for.
     * @return mixed The decoded response.
     */
    public function getCommits(string $repository);

    /**
     * Get the webhooks for the specific repository.
     *
     * @param string $repository The repository that we want to fetch webhooks for.
     * @return mixed The decoded response.
     */
    public function getWebhooks(string $repository): Response;

    /**
     * Create the webhook on the specific repository.
     *
     * @param string $repository The repository that we want to create a webhook for.
     * @return mixed The decoded response.
     */
    public function createWebhook(string $repository): Response;

    /**
     * Delete the webhook on the specific repository.
     *
     * @param int $id The id of the webhook to delete.
     * @param string $repository The repository that we want to delete a webhook for.
     * @return Response The decoded response.
     */
    public function deleteWebhook($id, $repository): Response;
}
