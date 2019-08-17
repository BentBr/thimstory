<?php

namespace thimstory\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use thimstory\Listeners\SendUserDeleteMail;
use thimstory\Listeners\SendUserLoginMail;
use thimstory\Listeners\SendUserRegisterMail;
use thimstory\Events\UserRegister;
use thimstory\Events\UserLogin;
use thimstory\Events\UserDelete;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //Registered::class => [
            //SendEmailVerificationNotification::class,
        //],
        UserRegister::class => [
            SendUserRegisterMail::class,
        ],
        UserLogin::class => [
            SendUserLoginMail::class,
        ],
        UserDelete::class => [
            SendUserDeleteMail::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
