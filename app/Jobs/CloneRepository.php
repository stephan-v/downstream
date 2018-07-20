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
     * Get the bash commands that are associated with this Laravel job.
     *
     * @return array
     */
    private function getCommands()
    {
        $project_path = '/home/forge/downstream-test.nl';
        $deployment_directory = "$project_path/releases/".time();
        $git_repository = 'git@github.com:stephan-v/beerquest.git';

        return [
            "mkdir -p $deployment_directory",
            "git clone --depth 1 $git_repository $deployment_directory",
            "cd $deployment_directory && composer install -o --no-interaction --prefer-dist",
            "ln -snf $deployment_directory $project_path/current",
            "cd $project_path/releases && ls -t | tail -n +6 | xargs rm -rf"
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $delimiter = 'EOF-DOWNSTREAM-APP';

        $this->runProcess(
            "ssh -tt forge@beerquest.nl 'bash -se' << \\$delimiter".PHP_EOL
                .implode(PHP_EOL, $this->getCommands()).PHP_EOL
            .$delimiter
        );
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

        $process->run(function ($type, $output) use ($converter) {
            $html = $converter->convert($output);

            event(new \App\Events\CloneRepository($html));
        });

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
