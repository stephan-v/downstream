<?php

namespace App\Ssh;

class DeploymentConfiguration {
    /**
     * The timestamp for this deployment.
     *
     * @var int $timestamp
     */
    protected $timestamp;

    /**
     * DeploymentConfiguration constructor.
     */
    public function __construct()
    {
        $this->timestamp = time();
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
        return '/home/forge/downstream-test.nl/' . env('APP_NAME');
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
        return $this->getProjectPath() . '/releases/' . $this->timestamp;
    }

    /**
     * Return the Git repository associated with this project.
     *
     * @return string
     */
    public function getRepository(): string
    {
        return 'git@github.com:stephan-v/beerquest.git';
    }

    /**
     * Return the server name.
     *
     * @return string
     */
    public function getConfiguredServer(): string
    {
        return 'forge@beerquest.nl';
    }
}
