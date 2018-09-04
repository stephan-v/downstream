<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The job is currently executing.
     */
    const RUNNING = 0;

    /**
     * The job is waiting to be executed.
     */
    const PENDING = 1;

    /**
     * The job failed to execute.
     */
    const FAILED = 2;

    /**
     * The job has executed without any errors.
     */
    const FINISHED = 3;

    /**
     * The attributes that should be hidden in JSON representations.
     *
     * @var array
     */
    protected $hidden = ['commands'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'output', 'deployment_id', 'server_id', 'status'];

    /**
     * Get the server that owns the job.
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Get the deployment that owns the job.
     */
    public function deployment()
    {
        return $this->belongsTo(Deployment::class);
    }
}
