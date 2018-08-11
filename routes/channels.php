<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/**
 * Verify that the user is allowed to listen to this private deployment.
 *
 * The project channel is used to announce new deployments.
 */
Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    return $user->id === \App\Project::findOrNew($projectId)->user_id;
});

/**
 * * Verify that the user is allowed to listen to this private deployment.
 *
 * The deployment channel is used to announce task changes.
 */
Broadcast::channel('deployment.{deploymentId}', function ($user, $deploymentId) {
    return $user->id === \App\Deployment::findOrNew($deploymentId)->user_id;
});
