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
 * Verify that the user is allowed to listen to private deployments.
 */
Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    return $user->id === \App\Project::findOrNew($projectId)->user_id;
});

/**
 * * Verify that the user is allowed to listen to this private deployment.
 */
Broadcast::channel('task.{taskId}', function ($user, $taskId) {
    return $user->id === \App\Job::findOrNew($taskId)->deployment->user_id;
});
