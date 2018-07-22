<?php

namespace App\Ssh;

use App\Events\BroadcastSSHOutput;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use SensioLabs\AnsiConverter\Theme\SolarizedTheme;
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
     * The event name.
     *
     * @var string $name
     */
    private $name;

    /**
     * Run SSH command(s) on the remote server with a here-doc statement.
     *
     * @param array $commands
     * @param string $target
     * @param string $name
     */
    public function __construct(array $commands, string $target, string $name)
    {
        $this->commands = $commands;
        $this->target = $target;
        $this->name = $name;
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

        $theme = new SolarizedTheme();
        $converter = new AnsiToHtmlConverter($theme);

        $process->run(function ($type, $output) use ($converter) {
            $html = $converter->convert($output);
            event(new BroadcastSSHOutput($html, $this->name));
        });

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
