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

class SubscribingUserUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscribingUser, $updatedUser, $content, $story;

    /**
     * Create a new event instance.
     *
     * SubscribingUserUpdate constructor.
     * @param User $subscribingUser
     * @param User $updatedUser
     * @param $content
     * @param Stories $story
     */
    public function __construct(User $subscribingUser, User $updatedUser, $content, Stories $story)
    {
        $this->subscribingUser  = $subscribingUser;
        $this->updatedUser      = $updatedUser;
        $this->content          = $content;
        $this->story            = $story;
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
