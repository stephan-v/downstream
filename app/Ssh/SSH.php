<?php

namespace App\Ssh;

use App\Events\CommandExecuted;
use App\Events\TaskUpdated;
use App\Task;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Run SSH command(s) on the remote server within a here-doc statement.
 */
class SSH {
    /**
     * The task that we want to process.
     *
     * @var Task $task
     */
    private $task;

    /**
     * Set the task.
     *
     * @param Task $task
     */
    public function setTask(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Convert our commands array to a PHP_EOL separated string which can be executed line by line.
     *
     * @return string Our PHP_EOL separated string.
     */
    private function getCommands(): string
    {
        $array = unserialize($this->task->commands);

        return implode(PHP_EOL, $array);
    }

    /**
     * Get the instantiated PHP process.
     *
     * @return Process The Symfony proc_* functions wrapper.
     */
    private function getRemoteProcess(): Process
    {
        $delimiter = 'EOF-DOWNSTREAM-APP';

        $task = $this->task;
        $target = $task->server->target;
        $commands = $this->getCommands();

        return new Process(
            "ssh $target 'bash -se' << \\$delimiter".PHP_EOL
            .$commands.PHP_EOL
            .$delimiter
        );
    }

    /**
     * Run the remote Symfony real-time process.
     */
    public function fire()
    {
        // Notify the frontend that the task started.
        event(new TaskUpdated(Task::PENDING, $this->task));

        $process = $this->getRemoteProcess();

        $process->run(function ($type, $output) {
            event(new CommandExecuted(
                $output,
                $this->task
            ));
        });

        if (!$process->isSuccessful()) {
            // Notify the frontend that the task failed.
            event(new TaskUpdated(Task::FAILED, $this->task));

            throw new ProcessFailedException($process);
        }

        // Notify the frontend that the task finished.
        event(new TaskUpdated(Task::FINISHED, $this->task));
    }
}
