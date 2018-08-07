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
     * The deployment failed to execute one of the tasks.
     */
    const FAILED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['commit', 'status', 'finished_at'];

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
        return $this->belongsTo('App\Project');
    }
}
