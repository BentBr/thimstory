<?php

namespace thimstory\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use thimstory\Models\UserSubscriptions;
use thimstory\Models\User;

class SubscriptionController extends Controller
{
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
            'location_redirect'   => 'required',
        ]);

        //get user
        $user = User::findOrFail(Auth::user()->id);
        $userToBeSubscribed = User::findOrFail($request->subscribed_user_id);

        //user can't subscribe on their own profile
        if ($user->id === $userToBeSubscribed->id) {

            return redirect($request->location_redirect);
        }

        //check if this is subscribe or unsubscribe
        $subscription = UserSubscriptions::isSubscriptionSet($userToBeSubscribed->id, $user->id);

        if (! is_null($subscription)) {

            //deleting existing subscription
            $subscription->unsubscribe();

            return redirect($request->location_redirect);
        } else {

            //subscribing
            $subscription = new UserSubscriptions();
            $subscription->subscribe($userToBeSubscribed->id, $user->id);

            return redirect($request->location_redirect);
        }
    }
}
