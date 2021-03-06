<?php

namespace thimstory\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use thimstory\Mail\SubscribingUserUpdateMail;

class SendSubscribingUserUpdateMail
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->subscribingUser->email)->send(
            new SubscribingUserUpdateMail($event->subscribingUser, $event->updatedUser, $event->content, $event->story)
        );
    }
}
