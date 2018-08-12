<?php

namespace App\Jobs;

use App\Deployment;
use App\Project;
use App\Server;
use App\Ssh\AbstractTask;
use App\Ssh\SSH;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CloneRepository extends AbstractTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The name of the current task.
     *
     * @var string $name
     */
    private $name = 'Clone repository';

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
            $task->commands = $this->commands($server, $this->project());
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
     * @param Project $project
     * @return string The serialized commands
     */
    private function commands(Server $server, Project $project): string
    {
        // Create a path with a timestamped directory to clone to.
        $deploymentPath = $server->releases . $this->timestamp();
        // Fetch the git repository to clone from.
        $gitRepository =  $project->cloneUrl;

        $commands = [
            "mkdir -p $deploymentPath",
            "git clone --depth 1 $gitRepository $deploymentPath",
            "exit"
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
