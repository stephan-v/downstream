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
 * Verify if the user is allowed to listen to this private deployment.
 */
Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    return $user->id === \App\Project::findOrNew($projectId)->user_id;
});

Broadcast::channel('task-status', function ($user) {
    return true;
});
