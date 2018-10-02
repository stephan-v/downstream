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
     * The attributes that should be hidden in JSON representations.
     *
     * @var array
     */
    protected $hidden = ['script'];

    /**
     * The servers that belong to the action.
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class)->withTimestamps();
    }
}
