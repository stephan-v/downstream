<?php

namespace App\Http\Controllers;

use App\Domain\HttpClients\VersionControlInterface;
use App\Project;
use Illuminate\Http\Response;

class WebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @param Project $project The project containing the repository we want to target.
     * @return Response The HTTP response message.
     */
    public function index(VersionControlInterface $client, Project $project): Response
    {
        $response = $client->getWebhooks($project->repository);
        $body = $response->getBody();

        return response($body, $response->getStatusCode());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @param Project $project The project containing the repository we want to target.
     * @return Response The HTTP response message.
     */
    public function store(VersionControlInterface $client, Project $project): Response
    {
        $response = $client->createWebhook($project->repository);
        $body = $response->getBody();

        return response($body, $response->getStatusCode());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @param int $id The id of the webhook to delete.
     * @param Project $project The project containing the repository we want to target.
     * @return Response The HTTP response message.
     */
    public function destroy(VersionControlInterface $client, int $id, Project $project): Response
    {
        $response = $client->deleteWebhook($id, $project->repository);
        $body = $response->getBody();

        return response($body, $response->getStatusCode());
    }

    /**
     * The webhook endpoint(also known as the payload url).
     *
     * @return Response The HTTP response message.
     */
    public function webhook(): Response
    {
        return response(['Webhook received successful']);
    }
}
