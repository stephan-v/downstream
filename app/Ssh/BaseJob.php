<?php

namespace App\Ssh;

abstract class BaseJob {
    /**
     * The deployment configuration.
     *
     * @var DeploymentConfiguration
     */
    protected $configuration;

    /**
     * BaseJob constructor.
     *
     * @param DeploymentConfiguration $configuration
     */
    public function __construct(DeploymentConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Return the absolute project path set by the user.
     *
     * We append our own application name to this so that our deploy related code is encapsulated.
     *
     * @return string
     */
    public function getProjectPath(): string
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
    public function getDeploymentPath(): string
    {
        return $this->configuration->getDeploymentPath();
    }

    /**
     * Return the Git repository associated with this project.
     *
     * @return string
     */
    public function getRepository(): string
    {
        return $this->configuration->getRepository();
    }

    /**
     * Return the server name.
     *
     * @return string
     */
    public function getConfiguredServer(): string
    {
        return $this->configuration->getConfiguredServer();
    }
}
