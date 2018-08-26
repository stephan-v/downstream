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
    protected $fillable = ['fqcn', 'script', 'order', 'server_id'];

    /**
     * Set the action's fully qualified class name(fqcn).
     *
     * @param string $value
     * @return void
     */
    public function setFqcnAttribute($value)
    {
        $this->attributes['fqcn'] = 'App\Jobs\\' . $value;
    }
}
