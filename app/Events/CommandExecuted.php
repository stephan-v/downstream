<?php

namespace App\Events;

use App\Job;
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
     * @var Job $task
     */
    private $task;

    /**
     * Create a new event instance.
     *
     * @param string $html
     * @param Job $task
     */
    public function __construct(string $html, Job $task)
    {
        $this->html = $html;
        $this->task = $task;

        $this->task->output .= $html;
        $this->task->save();
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
