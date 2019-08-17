<?php

namespace thimstory\Listeners;

use Mail;
use thimstory\Events\UserDelete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use thimstory\Mail\DeleteMail;

class SendUserDeleteMail
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
     * @param  UserDelete  $event
     * @return void
     */
    public function handle(UserDelete $event)
    {
        Mail::to($event->user->email)->send(
            new DeleteMail($event->user)
        );
    }
}
