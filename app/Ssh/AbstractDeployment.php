<?php

namespace App\Ssh;

use App\Deployment;
use App\Project;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractDeployment {
    /**
     * The freshly started deployment.
     *
     * @var Deployment $deployment
     */
    protected $deployment;

    /**
     * Deployment constructor.
     *
     * @param Deployment $deployment;
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

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

    /**
     * Get the short name of the current Job.
     *
     * @return string
     */
    protected function getShortName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
