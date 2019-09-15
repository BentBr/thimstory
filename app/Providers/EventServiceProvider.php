<?php

namespace thimstory\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use thimstory\Events\NewStoryOrDetail;
use thimstory\Listeners\CreateSubscriptionUpdate;
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
        UserRegister::class => [
            SendUserRegisterMail::class,
        ],
        UserLogin::class => [
            SendUserLoginMail::class,
        ],
        UserDelete::class => [
            SendUserDeleteMail::class,
        ],
        NewStoryOrDetail::class => [
            CreateSubscriptionUpdate::class,
        ],
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
