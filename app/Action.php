<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'icon', 'script'];

    /**
     * Get the actions's un-serialized script
     *
     * @param  string  $value
     * @return string
     */
    public function getScriptAttribute($value)
    {
        return unserialize($value);
    }

    /**
     * Set the actions's serialized script
     *
     * @param  string  $value
     * @return string
     */
    public function setScriptAttribute($value)
    {
        $this->attributes['script'] = serialize($value);
    }

    /**
     * The servers that belong to the action.
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class)->withTimestamps();
    }
}
