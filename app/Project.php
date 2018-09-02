<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The maximum number of deployments that being stored for re-deploy purposes.
     *
     * @var int $maxDeployments
     */
    public $maxDeployments = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'repository'];

    /**
     * Get the repository with Github prefixed for clone purposes.
     *
     * @return string
     */
    public function getCloneUrlAttribute(): string
    {
        return "git@github.com:{$this->repository}.git";
    }

    /**
     * Get the servers belonging to this project.
     */
    public function servers()
    {
        return $this->hasMany(Server::class);
    }

    /**
     * Get the deployments belonging to this project.
     */
    public function deployments()
    {
        return $this->hasMany(Deployment::class);
    }
}
