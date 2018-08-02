<?php

namespace App\Ssh;

use App\Events\BroadcastSSHOutput;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use SensioLabs\AnsiConverter\Theme\SolarizedTheme;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Run SSH command(s) on the remote server with a here-doc statement.
 */
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
     * The job name.
     *
     * @var string $jobName
     */
    private $jobName;

    /**
     * Set the commands to run on the target server.
     *
     * @var string[] $commands The server commands.
     */
    public function setCommands(array $commands)
    {
        $this->commands = $commands;
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
     * Set the name of the job which called this class.
     *
     * @param string $jobName
     */
    public function setJobName(string $jobName)
    {
        $this->jobName = $jobName;
    }

    /**
     * Get the name of the job which called this class.
     *
     * @return string
     */
    private function getJobName(): string
    {
        return $this->jobName;
    }

    /**
     * Set the server target to run remote SSH commands on.
     *
     * @param string $target
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    /**
     * Get the server target to run remote SSH commands on.
     */
    private function getTarget(): string
    {
        return $this->target;
    }

    /**
     * Get the instantiated PHP process.
     *
     * @return Process The Symfony proc_* functions wrapper.
     */
    private function getRemoteProcess(): Process
    {
        $delimiter = 'EOF-DOWNSTREAM-APP';
        $target = $this->getTarget();

        return new Process(
            "ssh $target 'bash -se' << \\$delimiter".PHP_EOL
            .$this->getCommands().PHP_EOL
            .$delimiter
        );
    }

    /**
     * Convert Ansi to HTML while applying the solarized theme to the SSH console output.
     *
     * @return AnsiToHtmlConverter
     */
    private function getThemeConverter(): AnsiToHtmlConverter
    {
        $theme = new SolarizedTheme();
        $converter = new AnsiToHtmlConverter($theme);

        return $converter;
    }

    /**
     * Run the remote Symfony real-time process.
     */
    public function fireRealTime()
    {
        $process = $this->getRemoteProcess();
        $converter = $this->getThemeConverter();

        $process->run(function ($type, $output) use ($converter) {
            event(new BroadcastSSHOutput(
                $converter->convert($output),
                $this->getJobName()
            ));
        });

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * Run the Symfony process.
     */
    public function fire(): string
    {
        $process = $this->getRemoteProcess();
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
