<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    /**
     * The deployment has finished without any errors.
     */
    const FINISHED = 0;

    /**
     * The deployment is currently in progress.
     */
    const PENDING = 1;

    /**
     * The deployment failed to execute one of the jobs.
     */
    const FAILED = 2;

    /**
     * The maximum number of deployments that are being kept for re-deploy purposes.
     *
     * @var int MAX_DEPLOYMENTS
     */
    const MAX_DEPLOYMENTS = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['commit', 'commit_url', 'status', 'finished_at', 'user_id'];

    /**
     * Typecast these properties during serialization.
     *
     * @var array $casts
     */
    protected $casts = [
        'status' => 'integer'
    ];

    /**
     * Get the project that owns the deployment.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the jobs that belong to the deployment.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the user that owns the deployment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
