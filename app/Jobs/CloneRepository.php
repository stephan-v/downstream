<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use SensioLabs\AnsiConverter\Theme\SolarizedTheme;
use Symfony\Component\Process\Process;

class CloneRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->runProcess('ls');
        $this->runProcess('pwd');
    }

    /**
     * Run the Symfony real-time process.
     *
     * @param $command
     */
    private function runProcess($command)
    {
        $process = new Process($command);

        $theme = new SolarizedTheme();
        $converter = new AnsiToHtmlConverter($theme);

        $process->run(function ($type, $buffer) use ($converter) {
            $html = $converter->convert($buffer);

            event(new \App\Events\CloneRepository($html));
        });

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
