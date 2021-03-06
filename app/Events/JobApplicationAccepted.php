<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobApplicationAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $job;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Job $job)
    {
        $this->user = $user;
        $this->job = $job;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.accepted' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'App.User.accepted' . $this->user->id;
    }

    public function broadcastWith()
    {
        return ['job' => $this->job];
    }
}
