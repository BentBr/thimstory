<?php

namespace thimstory\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use thimstory\Events\NewStoryOrDetail;
use thimstory\Models\SubscriptionUpdates;

class CreateSubscriptionUpdate
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
     * @param NewStoryOrDetail $event
     * @return void
     */
    public function handle(NewStoryOrDetail $event)
    {
        $subscriptionUpdate = new SubscriptionUpdates();
        $subscriptionUpdate->createWithType($event->user, $event->story, $event->type);
    }
}
