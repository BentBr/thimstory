<?php

namespace thimstory\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use thimstory\Models\Stories;
use thimstory\Models\User;

/**
 * Is being raised when a new story is being created
 *
 * Class NewStory
 * @package thimstory\Events
 */
class NewStoryOrDetail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $story;
    public $type;

    /**
     * Create a new event instance.
     *
     * NewStory constructor.
     * @param Stories $story
     * @param User $user
     * @param $type
     */
    public function __construct(User $user, Stories $story, $type)
    {
        $this->story = $story;
        $this->user  = $user;
        $this->type  = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
