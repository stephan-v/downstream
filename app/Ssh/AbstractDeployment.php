<?php

namespace App\Ssh;

abstract class AbstractDeployment {
    /**
     * The deployment configuration.
     *
     * @var DeploymentConfiguration
     */
    protected $configuration;

    /**
     * Deployment constructor.
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
