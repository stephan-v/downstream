<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
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
     * Get the actions belonging to the deployment pipeline of the project.
     */
    public function actions()
    {
        return $this
            ->belongsToMany(Action::class)
            ->withPivot('id', 'order')
            ->withTimestamps()
            ->orderBy('order');
    }

    /**
     * Get the order of the last action within the pipeline.
     *
     * @return int The order for the next action that will be inserted.
     */
    public function actionOrder(): int
    {
        $action = $this->actions()->latest('order')->first();

        return $action ? ++$action->pivot->order : 0;
    }

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
