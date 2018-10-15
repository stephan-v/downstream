<?php

namespace App\Events;

use App\Deployment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeploymentFinished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The freshly create deployment instance.
     *
     * @var Deployment $deployment
     */
    public $deployment;

    /**
     * The status of the deployment.
     *
     * This is set to public so that this data is being passed on to the frontend.
     *
     * @var int $status
     */
    public $status;

    /**
     * Create a new event instance.
     *
     * @param Deployment $deployment
     * @param int $status The deployment status, either having 'failed' or 'finished'.
     */
    public function __construct(Deployment $deployment, int $status)
    {
        $this->status = $status;
        $this->deployment = $deployment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('project.' . $this->deployment->project_id);
    }
}
