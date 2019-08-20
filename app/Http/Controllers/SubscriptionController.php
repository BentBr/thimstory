<?php

namespace thimstory\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use thimstory\Models\Stories;
use thimstory\Models\StorySubscriptions;
use thimstory\Models\User;

class SubscriptionController extends Controller
{
    public function putStorySubscription(Request $request)
    {
        $request->validate([
            'story_id'  => 'required|uuid',
        ]);

        //get user
        $user = User::findOrFail(Auth::user()->id);
        $story = Stories::findOrFail($request->story_id);

        //user can't subscribe own stories
        if ($user->id === $story->user_id) {

            return redirect(Route('story', [
                    'username' => $user->url_name, 'story' => $story->url_name  //todo: wrong uri
                ]));
        }

        //check if this is subscribe or unsubscribe
        $subscription = StorySubscriptions::isSubscriptionSet($story->id, $user->id);

        if (! is_null($subscription)) {

            //deleting existing subscription
            $subscription->unsubscribe();

            return redirect(Route('story', [
                    'username' => $user->url_name, 'story' => $story->url_name  //todo: wrong uri
                ]));
        } else {

            //subscribing
            $subscription = new StorySubscriptions();
            $subscription->subscribe($story->id, $user->id);

            return redirect(Route('story', [
                    'username' => $user->url_name, 'story' => $story->url_name  //todo: wrong uri
                ]));
        }
    }

    public function putUserSubscription()
    {

    }
}
