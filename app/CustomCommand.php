<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomCommand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'script', 'order', 'server_id'];

    /**
     * Get the command's pipeline.
     */
    public function pipeline()
    {
        return $this->morphOne(Pipeline::class, 'commands');
    }
}
