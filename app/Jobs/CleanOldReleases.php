<?php

namespace App\Jobs;

use App\Deployment;
use App\Server;
use App\Ssh\AbstractTask;
use App\Ssh\SSH;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CleanOldReleases extends AbstractTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The name of the current task.
     *
     * @var string $name
     */
    private $name = 'Clean old releases';

    /**
     * Deployment constructor.
     *
     * @param Deployment $deployment;
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;

        // Foreach server create the task that we are running on the server.
        foreach ($this->servers() as $server) {
            $task = new Task();

            $task->name = $this->name;
            $task->commands = $this->commands($server);
            $task->deployment()->associate($this->deployment);
            $task->server()->associate($server);
            $task->status = Task::FINISHED;

            // Tap returns the model instead of the true or false boolean for the saved state.
            $this->tasks[] = tap($task)->save();
        }
    }

    /**
     * Get the bash commands that are associated with this job.
     *
     * @param Server $server
     * @return string The serialized commands
     */
    private function commands(Server $server): string
    {
        // Create a path with a timestamped directory to clone to.
        $deploymentPath = $server->releases . $this->timestamp();
        $releasesPath = $server->releases;
        $symlinkPath = $server->current;

        $commands = [
            "ln -snf $deploymentPath $symlinkPath",
            "cd $releasesPath && ls -t | tail -n +6 | xargs rm -rf"
        ];

        return serialize($commands);
    }

    /**
     * Execute the job.
     *
     * @param SSH $ssh The SSH singleton to run remote commands.
     */
    public function handle(SSH $ssh)
    {
        foreach ($this->tasks as $task) {
            $ssh->setTask($task);
            $ssh->fire();
        }
    }
}
