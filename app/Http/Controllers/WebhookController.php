<?php

namespace App\Http\Controllers;

use App\Domain\HttpClients\VersionControlInterface;
use Illuminate\Http\Response;

class WebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @return Response The HTTP response message.
     */
    public function index(VersionControlInterface $client): Response
    {
        $response = $client->getWebhooks();
        $body = $response->getBody();

        return response($body, $response->getStatusCode());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @return Response The HTTP response message.
     */
    public function store(VersionControlInterface $client): Response
    {
        $response = $client->createWebhook();
        $body = $response->getBody();

        return response($body, $response->getStatusCode());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @param int $id The id of the webhook to delete.
     * @return Response The HTTP response message.
     */
    public function destroy(VersionControlInterface $client, int $id): Response
    {
        $response = $client->deleteWebhook($id);
        $body = $response->getBody();

        return response($body, $response->getStatusCode());
    }

    /**
     * The webhook endpoint.
     *
     * @return Response The HTTP response message.
     */
    public function webhook(): Response
    {
        return response(['Webhook received successful']);
    }
}
