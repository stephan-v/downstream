<?php

namespace App\Events;

use App\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The status of the task.
     *
     * This is set to public so that this data is being passed on to the frontend.
     *
     * @var int $status
     */
    public $status;

    /**
     * The task that we want to process.
     *
     * @var Task $task
     */
    private $task;

    /**
     * Create a new event instance.
     *
     * @param int $status The updated status of the task.
     * @param Task $task
     */
    public function __construct(int $status, Task $task)
    {
        $this->status = $status;
        $this->task = $task;

        $this->updateTask($this->status, $this->task);
    }

    /**
     * Update the task
     *
     * Besides broadcasting to the frontend we also want to update our database task record.
     *
     * @param int $status
     * @param Model $task
     */
    private function updateTask(int $status, Model $task)
    {
        $task->status = $status;
        $task->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('task.' . $this->task->id);
    }
}
