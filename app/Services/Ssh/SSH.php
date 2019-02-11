<?php

namespace App\Services\Ssh;

use App\Events\CommandExecuted;
use App\Events\JobUpdated;
use App\Job;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

/**
 * Run SSH command(s) on the remote server within a here-doc statement.
 */
class SSH 
{
    /**
     * The job that we want to process.
     *
     * @var Job $job
     */
    private $job;

    /**
     * Set the job.
     *
     * @param Job $job
     */
    public function setJob(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Convert our commands array to a PHP_EOL separated string which can be executed line by line.
     *
     * @return string Our PHP_EOL separated string.
     */
    private function getCommands(): string
    {
        $array = unserialize($this->job->commands);

        return implode(PHP_EOL, $array);
    }

    /**
     * Get a newly instantiated Symfony process.
     *
     * This allows us to perform bash scripts on a remote server.
     *
     * The -s bash option allows bash to read its command from standard input,
     * rather than from a file named by the first positional argument.
     *
     * @return Process The Symfony proc_* functions wrapper.
     */
    private function getRemoteProcess(): Process
    {
        $delimiter = 'EOF-DOWNSTREAM-APP';

        $job = $this->job;
        $disableHostAuthentication = "-o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no";
        $target = $job->server->target;
        $commands = $this->getCommands();

        return new Process(
            "ssh $disableHostAuthentication $target 'bash -se' << \\$delimiter".PHP_EOL
            .'set -e'.PHP_EOL
            .$commands.PHP_EOL
            .$delimiter
        );
    }

    /**
     * Run the remote Symfony real-time process.
     */
    public function fire()
    {
        event(new JobUpdated(Job::RUNNING, $this->job));

        $process = $this->getRemoteProcess();

        $process->setTimeout(null);

        try {
            $process->run(function ($type, $output) {
                event(new CommandExecuted(
                    $output,
                    $this->job
                ));
            });
        } catch(RuntimeException $exception) {
            event(new JobUpdated(Job::FAILED, $this->job));
        }

        if (!$process->isSuccessful()) {
            event(new JobUpdated(Job::FAILED, $this->job));

            throw new ProcessFailedException($process);
        }

        event(new JobUpdated(Job::FINISHED, $this->job));
    }
}
