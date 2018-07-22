<?php

namespace App\Jobs;

use App\Events\BroadcastSSHOutput;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use SensioLabs\AnsiConverter\Theme\SolarizedTheme;
use Symfony\Component\Process\Process;

class SSH {
    /**
     * Run SSH command(s) on the remote server with a here-doc statement.
     *
     * @param array $commands
     * @param string $target
     */
    public function __construct(array $commands, string $target)
    {
        $delimiter = 'EOF-DOWNSTREAM-APP';

        $this->run(
            "ssh $target 'bash -se' << \\$delimiter".PHP_EOL
            .implode(PHP_EOL, $commands).PHP_EOL
            .$delimiter
        );
    }

    /**
     * Run the Symfony real-time process.
     *
     * @param $command
     */
    protected function run($command)
    {
        $process = new Process($command);

        $theme = new SolarizedTheme();
        $converter = new AnsiToHtmlConverter($theme);

        $process->run(function ($type, $output) use ($converter) {
            $html = $converter->convert($output);
            event(new BroadcastSSHOutput($html));
        });

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
