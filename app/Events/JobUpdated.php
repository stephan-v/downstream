<?php

namespace App\Events;

use App\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The status of the job.
     *
     * This is set to public so that this data is being passed on to the frontend.
     *
     * @var int $status
     */
    public $status;

    /**
     * The job that we want to process.
     *
     * @var Job $job
     */
    private $job;

    /**
     * Create a new event instance.
     *
     * @param int $status The updated status of the job.
     * @param Job $job
     */
    public function __construct(int $status, Job $job)
    {
        $this->status = $status;
        $this->job = $job;

        $this->updateTask($this->status, $this->job);
    }

    /**
     * Update the job
     *
     * Besides broadcasting to the frontend we also want to update our database job record.
     *
     * @param int $status
     * @param Model $job
     */
    private function updateTask(int $status, Model $job)
    {
        $job->status = $status;
        $job->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('task.' . $this->job->id);
    }
}
