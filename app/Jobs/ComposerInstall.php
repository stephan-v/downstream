<?php

namespace App\Jobs;

use App\Deployment;
use App\Ssh\AbstractTask;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ComposerInstall extends AbstractTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The name of the current task.
     *
     * @var string $name
     */
    private $name = 'Composer install';

    /**
     * The bash commands that are associated with this task.
     *
     * @var array $commands Array of commands to run one by one on a specified server.
     */
    private $commands = [
        'cd {{ $release }}',
        'composer install -o --no-interaction --prefer-dist'
    ];

    /**
     * CloneRepository constructor.
     *
     * @param Deployment $deployment
     */
    public function __construct(Deployment $deployment)
    {
        parent::__construct($deployment, $this->name, $this->commands);
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
