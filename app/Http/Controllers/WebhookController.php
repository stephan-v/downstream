<?php

namespace App\Http\Controllers;

use App\Deployment;
use App\Jobs\StartDeployment;
use App\Services\HttpClients\VersionControlInterface;
use App\Project;
use App\Services\Webhook\Webhook;
use Illuminate\Http\Request;
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
        return response($client->getWebhooks($project->repository));
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
        return response($client->createWebhook($project->repository));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     * @param Project $project The project containing the repository we want to target.
     * @param int $id The id of the webhook to delete.
     * @return Response The HTTP response message.
     */
    public function destroy(VersionControlInterface $client, Project $project, int $id): Response
    {
        return response($client->deleteWebhook($id, $project->repository));
    }

    /**
     * The webhook endpoint(also known as the payload url).
     *
     * @param Request $request The incoming HTTP server request.
     * @return Response The HTTP response message.
     */
    public function webhook(Request $request): Response
    {
        if (Webhook::isNotSecure($request)) {
            abort(401, 'Unauthorized request.');
        }

        if ($request->header('X-GitHub-Event') === Webhook::PUSH_EVENT) {
            $payload = json_decode($request->getContent());
            $project = Project::where('repository', $payload->repository->full_name)->firstOrFail();

            $deployment = new Deployment([
                'user_id' => $project->user->id,
                'commit' => $payload->head_commit->id,
                'commit_url' => $payload->repository->full_name
            ]);

            StartDeployment::dispatch($project, $deployment);
        }

        return response(['success' => 'Webhook event received successfully.']);
    }
}
