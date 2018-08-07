<?php

namespace App\Ssh;

use App\Project;
use App\Server;

class DeploymentConfiguration {
    /**
     * The project coupled to this deployment.
     *
     * @var Project $project
     */
    private $project;

    /**
     * The server coupled to this deployment.
     *
     * @var Project $server
     */
    private $server;

    /**
     * DeploymentConfiguration constructor.
     *
     * @param Project $project
     * @param Server $server
     */
    public function __construct(Project $project, Server $server)
    {
        $this->project = $project;
        $this->server = $server;
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
        $path = $this->server->path;

        return $path . env('APP_NAME');
    }

    /**
     * Return the deployment path.
     *
     * @return string
     */
    public function getDeploymentPath(): string
    {
        return $this->getProjectPath() . '/releases/';
    }

    /**
     * Return the Git repository associated with this project.
     *
     * @return string
     */
    public function getRepository(): string
    {
        $repository = $this->project->repository;

        return "git@github.com:{$repository}.git";
    }

    /**
     * Return the server name.
     *
     * @return string
     */
    public function getServerName(): string
    {
        $user = $this->server->user;
        $ip_address = $this->server->ip_address;

        return "{$user}@{$ip_address}";
    }
}
