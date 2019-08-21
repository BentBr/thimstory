<?php

namespace thimstory\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use thimstory\Models\Stories;
use thimstory\Models\StorySubscriptions;
use thimstory\Models\UserSubscriptions;
use thimstory\Models\User;

class SubscriptionController extends Controller
{
    /**
     * Putting new Story subscriptions or deleting them if existing (subscribe / unsubscribe)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function putStorySubscription(Request $request)
    {
        $request->validate([
            'story_id'  => 'required|uuid',
        ]);

        //get user
        $user = User::findOrFail(Auth::user()->id);
        $story = Stories::findOrFail($request->story_id);
        $storyUser = $story->user;

        //user can't subscribe own stories
        if ($user->id === $story->user_id) {

            return redirect(Route('story', [
                    'username' => $storyUser->url_name, 'story' => $story->url_name
                ]));
        }

        //check if this is subscribe or unsubscribe
        $subscription = StorySubscriptions::isSubscriptionSet($story->id, $user->id);

        if (! is_null($subscription)) {

            //deleting existing subscription
            $subscription->unsubscribe();

            return redirect(Route('story', [
                    'username' => $storyUser->url_name, 'story' => $story->url_name
                ]));
        } else {

            //subscribing
            $subscription = new StorySubscriptions();
            $subscription->subscribe($story->id, $user->id);

            return redirect(Route('story', [
                    'username' => $storyUser->url_name, 'story' => $story->url_name
                ]));
        }
    }

    /**
     * Putting new User subscriptions or deleting them if existing (subscribe / unsubscribe)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function putUserSubscription(Request $request)
    {
        $request->validate([
            'subscribed_user_id'  => 'required|uuid',
        ]);

        //get user
        $user = User::findOrFail(Auth::user()->id);
        $userToBeSubscribed = User::findOrFail($request->subscribed_user_id);

        //user can't subscribe on their own profile
        if ($user->id === $userToBeSubscribed->id) {

            return redirect(Route('profile', [
                'username' => $userToBeSubscribed->url_name,
            ]));
        }

        //check if this is subscribe or unsubscribe
        $subscription = UserSubscriptions::isSubscriptionSet($userToBeSubscribed->id, $user->id);

        if (! is_null($subscription)) {

            //deleting existing subscription
            $subscription->unsubscribe();

            return redirect(Route('profile', [
                'username' => $userToBeSubscribed->url_name,
            ]));
        } else {

            //subscribing
            $subscription = new UserSubscriptions();
            $subscription->subscribe($userToBeSubscribed->id, $user->id);

            return redirect(Route('profile', [
                'username' => $userToBeSubscribed->url_name,
            ]));
        }
    }
}
