<?php

namespace App\Ssh;

use App\Events\BroadcastSSHOutput;
use Symfony\Component\Process\Process;

class SSH {
    /**
     * The commands to run on the target server.
     *
     * @var array $commands
     */
    private $commands;


    /**
     * The server we want to target for our SSH commands.
     *
     * @var int $target our complete server name including our prefixed user.
     */
    private $target;

    /**
     * Run SSH command(s) on the remote server with a here-doc statement.
     *
     * @param array $commands
     * @param string $target
     */
    public function __construct(array $commands, string $target)
    {
        $this->commands = $commands;
        $this->target = $target;
    }

    private function getRemoteProcess(): Process
    {
        $delimiter = 'EOF-DOWNSTREAM-APP';

        return new Process(
            "ssh $this->target 'bash -se' << \\$delimiter".PHP_EOL
            .$this->getCommands().PHP_EOL
            .$delimiter
        );
    }

    /**
     * Convert our commands array to a PHP_EOL separated string which can be executed line by line.
     *
     * @return string Our PHP_EOL separated string.
     */
    private function getCommands(): string
    {
        return implode(PHP_EOL, $this->commands);
    }

    /**
     * Run the Symfony real-time process.
     */
    public function fire()
    {
        $process = $this->getRemoteProcess();

        $process->run(function ($type, $output) {
            event(new BroadcastSSHOutput($output));
        });

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
