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
     * Get the servers for the project.
     */
    public function servers()
    {
        return $this->hasMany('App\Server');
    }

    /**
     * Get the main server for the project.
     */
    public function getServerAttribute()
    {
        return $this->servers()->first();
    }
}
