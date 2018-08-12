<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The task has finished without any errors.
     */
    const FINISHED = 0;

    /**
     * The task is currently in progress.
     */
    const PENDING = 1;

    /**
     * The task failed to execute.
     */
    const FAILED = 2;

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
     * Get the server that owns the task.
     */
    public function server()
    {
        return $this->belongsTo('App\Server');
    }

    /**
     * Get the deployment that owns the task.
     */
    public function deployment()
    {
        return $this->belongsTo('App\Deployment');
    }
}
