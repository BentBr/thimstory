<?php

namespace thimstory\Console\Commands;

use Illuminate\Console\Command;
use thimstory\Events\SubscribingUserUpdate;
use thimstory\Models\StorySubscriptions;
use thimstory\Models\UserSubscriptions;
use Exception;

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
        /*
         * Users are subscribing other users. A users gets updated if he is adding a new story or a new story detail
         * An email is sent to every user subscriber of which stories got updated
         * An email is sent to every user subscriber of which story details of certain stories got updated
         */
        //looking for stories to update
        $userSubscriptions = UserSubscriptions::with('subscribedUser.stories.storyDetails', 'user')
            ->whereHas('subscribedUser.stories', function ($query) {
                $query->where('cron_update_needed', true);
            })->orWhereHas('subscribedUser.stories.storyDetails', function ($query) {
                $query->where('cron_update_needed', true);
            })->get();

        //todo: send mail to every user of subscriptions
        //todo: avoid redundant mails if users have user + story subs
        foreach ($userSubscriptions as $userSubscription) {

            echo "Story Author " . $userSubscription->subscribedUser->stories->user->name . "\n";

            //could be multiple->collection
            echo "Story Detail id with update" . $userSubscription->stories->storyDetails[0]->id . "\n";

            echo "Update Recipient " . $userSubscription->user->name . "\n";

        }

        //timestamp must not be changed by updating cron_update_needed
        $this->timestamps = false;

        //setting cron_update_needed to false again
        foreach ($userSubscriptions as $userSubscription) {

echo 'ping';
        }

        //todo: set cron_update_needed to false
        //todo: built email stack to send

        //building mail stack
        foreach($userSubscriptions as $userSubscription) {

            $mailStack ='';
        }
exit;
        //send login mail for each in mail stack
        foreach($mailStack as $mail) {

            try {
                //todo:mail must be built (template + events, listener, mail be checked)
                event(new SubscribingUserUpdate($mail->subscribingUser, $mail->updatedUser, $mail->content));
            } catch (Exception $exception) {

                //todo: just testing
                echo 'error:' . $exception;
            }
        }

    }
}
