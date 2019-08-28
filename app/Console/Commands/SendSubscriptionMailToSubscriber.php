<?php

namespace thimstory\Console\Commands;

use Illuminate\Console\Command;
use thimstory\Models\Stories;
use thimstory\Models\StorySubscriptions;
use thimstory\Models\User;
use thimstory\Models\UserSubscriptions;

class SendSubscriptionMailToSubscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendSubscriptionMails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Mails to story subscribers and user subscribers';

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
     * If a user is being subscribed update hangs on stories due to new story info is being sent and not info about user
     * If a story is being subscribed update hangs on storyDetails due to new images in details below story level
     *
     * @return mixed
     */
    public function handle()
    {
        //looking for stories to update
        $userSubscriptions = UserSubscriptions::with('subscribedUser', 'user')
            ->get();

        //looking for storyDetails to update
        $storySubscriptions = StorySubscriptions::with('stories.user', 'stories.storyDetails', 'user')
            ->whereHas('stories.storyDetails', function ($query) {
                $query->where('cron_update_needed', true);
            })
            ->get();

        //todo: send mail to every user of subscriptions
        foreach ($storySubscriptions as $storySubscription) {

            echo "Story Author " . $storySubscription->stories->user->name . "\n";

            //could be multiple
            echo "Story Detail id with update" . $storySubscription->stories->storyDetails[0]->id . "\n";

            echo "Update Recipient " . $storySubscription->user->name . "\n";

        }

        //timestamp must not be changed by updating cron_update_needed
        $this->timestamps = false;

        //todo: set cron_update_needed to false

    }
}
