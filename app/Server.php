<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user', 'path', 'ip_address', 'project_id'];

    /**
     * Get the server target which is a full SSH bind_address.
     *
     * @return string
     */
    public function getTargetAttribute()
    {
        return "{$this->user}@{$this->ip_address}";
    }

    /**
     * Get the server path to clone the deployment repository to.
     *
     * @return string The modified path value.
     */
    public function getReleasesAttribute(): string
    {
        return $this->path . '/releases/';
    }

    /**
     * Get the server symlink path which points to the latest release.
     *
     * @return string The modified path value.
     */
    public function getCurrentAttribute(): string
    {
        return $this->path . '/current';
    }
}
