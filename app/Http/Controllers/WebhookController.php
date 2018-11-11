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
        $response = $client->getWebhook();
        $body = $response->getBody();

        return response(json_decode($body), $response->getStatusCode());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @return Response The HTTP response message.
     */
    public function store(VersionControlInterface $client): Response
    {
        $response = $client->setWebhook();
        $body  = $response->getBody();

        return response(json_decode($body), $response->getStatusCode());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
