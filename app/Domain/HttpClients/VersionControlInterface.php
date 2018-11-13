<?php

namespace App\Domain\HttpClients;

use GuzzleHttp\Psr7\Response;

interface VersionControlInterface
{
    /**
     * Get a  list of commits on a repository.
     *
     * @return mixed The decoded response.
     */
    public function getCommits();

    /**
     * Get the webhooks for the specific repository.
     *
     * @return mixed The decoded response.
     */
    public function getWebhooks(): Response;

    /**
     * Create the webhook on the specific repository.
     *
     * @return mixed The decoded response.
     */
    public function createWebhook(): Response;

    /**
     * Delete the webhook on the specific repository.
     *
     * @param int $id The id of the webhook to delete.
     * @return Response The decoded response.
     */
    public function deleteWebhook($id): Response;
}
