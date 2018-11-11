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
     * Get the webhook for the specific repository.
     *
     * @return mixed The decoded response.
     */
    public function getWebhook(): Response;

    /**
     * Set the webhook on the specific repository.
     *
     * @return mixed The decoded response.
     */
    public function setWebhook(): Response;
}
