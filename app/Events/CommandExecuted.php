<?php

namespace App\Events;

use App\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommandExecuted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The HTML string.
     *
     * @var string $html
     */
    public $html = '';

    /**
     * The task that we want to process.
     *
     * @var Task $task
     */
    private $task;

    /**
     * Create a new event instance.
     *
     * @param string $html
     * @param Task $task
     */
    public function __construct(string $html, Task $task)
    {
        $this->html = $html;
        $this->task = $task;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('task.' . $this->task->id);
    }
}
