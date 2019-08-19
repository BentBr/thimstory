<?php

namespace thimstory\Console\Commands;

use Illuminate\Console\Command;
use thimstory\Models\User;

class UpdateViewCountsOfAllUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateViewCounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cycles through all users and updates view counts based on views on stories + story details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //getting all users
        $users = User::with('stories')
            ->get();

        //going through every user
        foreach ($users as $user) {

            $counter = 0;

            //going through stories
            if(count($user->stories)) {
                foreach($user->stories as $story) {

                    $counter += $story->views;

                    //going through story details
                    if(count($story->storyDetails)) {
                        foreach ($story->storyDetails as $storyDetail) {

                            $counter += $storyDetail->views;
                        }
                    }
                }
            }

            //update users view counts without timestamps
            $user->timestamps = false;
            $user->forceFill(['views' => $counter])
                ->save();
        }
    }
}
