<?php

namespace thimstory\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //if logged-in returning data for new story (timing)
        $data['newStoryDetail'] = Auth::check() ? Auth::user()->getDateForNextStoryDetail() : null;
        //and sharing to all views
        view()->share($data);
    }
}
