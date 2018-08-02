<?php

namespace App\Ssh;

use App\Project;

abstract class AbstractDeployment {
    /**
     * The deployment configuration.
     *
     * @var DeploymentConfiguration
     */
    protected $configuration;

    /**
     * The project coupled to this deployment.
     *
     * @var Project $project
     */
    protected $project;

    /**
     * Deployment constructor.
     *
     * @param DeploymentConfiguration $configuration
     * @param Project $project
     */
    public function __construct(
        DeploymentConfiguration $configuration,
        Project $project = null
    ) {
        $this->configuration = $configuration;
        $this->project = $project;
    }

    /**
     * Return the absolute project path set by the user.
     *
     * We append our own application name to this so that our deploy related code is encapsulated.
     *
     * @return string
     */
    protected function getProjectPath(): string
    {
        return $this->configuration->getProjectPath();
    }

    /**
     * Return the deployment path.
     *
     * We want each deployment to be in a unique directory so put each release in a timestamped
     * directory under a 'releases' directory.
     *
     * @return string
     */
    protected function getDeploymentPath(): string
    {
        return $this->configuration->getDeploymentPath();
    }

    /**
     * Return the Git repository associated with this project.
     *
     * @return string
     */
    protected function getRepository(): string
    {
        return $this->configuration->getRepository();
    }

    /**
     * Return the server name.
     *
     * @return string
     */
    protected function getServerName(): string
    {
        return $this->configuration->getServerName();
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
