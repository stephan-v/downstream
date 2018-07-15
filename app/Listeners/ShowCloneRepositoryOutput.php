<?php

namespace App\Listeners;

use App\Events\CloneRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShowCloneRepositoryOutput
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CloneRepository  $event
     * @return void
     */
    public function handle(CloneRepository $event)
    {
        //
    }
}
