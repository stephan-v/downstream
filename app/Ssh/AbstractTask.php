<?php

namespace App\Ssh;

use App\Deployment;
use App\Project;
use App\Task;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractTask {
    /**
     * The freshly started deployment.
     *
     * @var Deployment $deployment
     */
    protected $deployment;

    /**
     * The created tasks.
     *
     * @var Task[] $tasks
     */
    protected $tasks;

    /**
     * Return the project which own this deployment.
     *
     * @return Project
     */
    protected function project(): Project
    {
        return $this->deployment->project;
    }

    /**
     * Return the deployment created_at timestamp.
     *
     * @return int The unix timestamp.
     */
    protected function timestamp(): int
    {
        return $this->deployment->created_at->timestamp;
    }

    /**
     * Return all servers belong to this deployment's project.
     *
     * @return Collection An Eloquent collection of hydrated server instances.
     */
    protected function servers(): Collection
    {
        return $this->project()->servers;
    }
}
