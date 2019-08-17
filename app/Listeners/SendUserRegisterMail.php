<?php

namespace thimstory\Listeners;

use thimstory\Events\UserRegister;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use thimstory\Mail\RegisterMail;
use Mail;

class SendUserRegisterMail
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
     * @param  UserRegister  $event
     * @return void
     */
    public function handle(UserRegister $event)
    {
        Mail::to($event->user->email)->send(
            new RegisterMail($event->user)
        );
    }
}
