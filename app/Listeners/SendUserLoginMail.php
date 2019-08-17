<?php

namespace thimstory\Listeners;

use Mail;
use thimstory\Events\UserLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use thimstory\Mail\LoginMail;

class SendUserLoginMail
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
     * @param  UserLogin  $event
     * @return void
     */
    public function handle(UserLogin $event)
    {
        Mail::to($event->user->email)->send(
            new LoginMail($event->user)
        );
    }
}
