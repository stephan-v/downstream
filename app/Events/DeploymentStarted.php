<?php

namespace App\Events;

use App\Deployment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeploymentStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The freshly create deployment instance.
     *
     * @var Deployment $deployment
     */
    public $deployment;

    public $created_at;

    public $commit;

    /**
     * Create a new event instance.
     *
     * @TODO FIX the model from not serializing properly.
     *
     * @param Deployment $deployment
     */
    public function __construct(Deployment $deployment)
    {
        $this->$deployment = $deployment;
        $this->created_at = $deployment->created_at;
        $this->commit = $deployment->commit;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('deployment');
    }
}
