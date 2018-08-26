<?php

namespace App\Ssh;

use App\Deployment;
use App\Server;
use App\Task;

abstract class AbstractTask {
    use CompilesCommandsTrait;

    /**
     * The bash commands that are associated with this task.
     *
     * @var array $commands Array of commands to run one by one on a specified server.
     */
    private $commands;

    /**
     * The freshly started deployment.
     *
     * @var Deployment $deployment
     */
    protected $deployment;

    /**
     * The name of the current task.
     *
     * @var string $name
     */
    private $name;

    /**
     * The created tasks.
     *
     * @var Task[] $tasks
     */
    protected $tasks;

    /**
     * Deployment constructor.
     *
     * @param Deployment $deployment;
     * @param string $name
     * @param array $commands
     */
    public function __construct(Deployment $deployment, string $name, array $commands)
    {
        $this->deployment = $deployment;
        $this->name = $name;
        $this->commands = $commands;

        $this->saveTasksToDatabase();
    }

    /**
     * Save the tasks to the database.
     */
    protected function saveTasksToDatabase()
    {
        $servers = $this->deployment->project->servers;

        foreach ($servers as $server) {
            $this->createTask($server);
        }
    }

    /**
     * Persist task to the database.
     *
     * @param Server $server
     */
    private function createTask(Server $server)
    {
        $task = new Task();

        $task->name = $this->name;
        $task->commands = $this->compileCommands($server);
        $task->deployment()->associate($this->deployment);
        $task->server()->associate($server);
        $task->status = Task::PENDING;

        $this->tasks[] = tap($task)->save();
    }
}
