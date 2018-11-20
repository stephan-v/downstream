<?php

namespace App\Services\HttpClients;

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
     * @return null|array The decoded response.
     */
    public function getWebhooks(string $repository): ?array;

    /**
     * Create the webhook on the specific repository.
     *
     * @param string $repository The repository that we want to create a webhook for.
     * @return object The response.
     */
    public function createWebhook(string $repository);

    /**
     * Delete the webhook on the specific repository.
     *
     * @param int $id The id of the webhook to delete.
     * @param string $repository The repository that we want to delete a webhook for.
     * @return null The decoded response.
     */
    public function deleteWebhook($id, $repository);
}
