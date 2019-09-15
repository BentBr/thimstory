<?php

namespace thimstory\Console\Commands;

use Illuminate\Console\Command;
use thimstory\Events\SubscribingUserUpdate;
use thimstory\Models\User;
use thimstory\Models\UserSubscriptions;
use thimstory\Models\SubscriptionUpdates;
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
         * ###### Rough timetable how to run: ######
         *
         * getting all updates                                          //check
         * getting all relevant subs (through updates)                  //check
         * getting all relevant users, stories, authors (through subs)  //check, check, check
         *
         * creating stack of notifications                              //check via smart query
         * sending notifications                                        //check
         * having proper mail content                                   //check
         * (logging sent per notification)                              //
         *
         * increasing counter for notifications_sent on subs            //
         * deleting updates                                             //check
         *
         *
         */


        /*
         * Users are subscribing other users. Users gets updated if he(author) is adding a new story or a new story detail
         * An email is sent to every user subscriber of which stories got updated
         * An email is sent to every user subscriber of which story details of certain stories got updated
         */

        /*
         * In this current version for every update a email is sent
         * Todo: aggregated mails
         */

        //getting all updates which have corresponding id in subscriptions
        //updates of users without subs do not need to trigger notification
        $updates = SubscriptionUpdates::getRelevantUpdates();

        //looping though all relevant updates
        foreach ($updates as $update) {

            //looping through all subs of authors(updatedUser) of updates
            foreach ($update->updatedUser->userSubscriptions as $subscription) {

                //checking if sub is relevant
                if(in_array($subscription->subscribed_user_id, (array) $update)) {

                    //sending an email for every subscription
                    if (event(new SubscribingUserUpdate($subscription->user, $update->updatedUser, $update->event, $update->updatedStory))) {

                        //updating such as send mail counter + 1
                        if (! $subscription->incrementSentCounter()) {
                            return false;
                        }
                    } else {

                        return false;
                    }
                }
            }
        }

        //deleting all updates after successful iteration
        if (! SubscriptionUpdates::truncate()) {

            return false;
        }

        return true; //todo: proper logging needed
    }
}
