<?php

namespace App\Providers;

use App\Events\TaskFinished;
use App\Events\TaskStarted;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Queue::before(function (JobProcessing $event) {
            $job = $event->job;
            $name = $event->job->resolveName();

            if ($this->isJob($job)) {
                event(new TaskStarted($name));
            }
        });

        Queue::after(function (JobProcessed $event) {
            $job = $event->job;
            $name = $event->job->resolveName();

            if ($this->isJob($job)) {
                event(new TaskFinished($name));
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Return a boolean check to see whether we are actually dealing with a job.
     *
     * @param Job $job
     * @return bool
     */
    private function isJob(Job $job): bool
    {
        return str_contains($job->resolveName(), 'Jobs');
    }
}
