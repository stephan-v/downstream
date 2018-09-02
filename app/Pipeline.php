<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    /**
     * Get all of the owning command models.
     */
    public function commands()
    {
        return $this->morphTo('commands', 'command_id', 'command_type');
    }
}
