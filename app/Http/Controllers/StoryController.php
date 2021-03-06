<?php

namespace thimstory\Http\Controllers;

use thimstory\Models\StoryDetails;
use thimstory\Models\User;
use thimstory\Models\Stories;
use Auth;
use Illuminate\Http\Request;
use File;
use thimstory\Models\UserSubscriptions;
use Lang;

class StoryController extends Controller
{
    /**
     * Renders all stories of user {username}/stories
     *
     * @param $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stories($username)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);

        //sorting must be forced due to uuid which has no intrinsic sorting in collection
        $data['stories'] = $data['user']->stories->sortBy('created_at');

        //getting if user is subscriber of certain story
        if(Auth::check()) {

            $data['userSubscribed'] = UserSubscriptions
                ::isSubscriptionSet($data['user']->id, Auth::user()->id);
        } else {

            $data['userSubscribed'] = null;
        }

        return view('stories.stories', $data);
    }

    /**
     * Renders requested story overview {username}/{story}
     *
     * @param $username
     * @param $story
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function story($username, $story)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);
        $data['story'] = Stories::getStoryByUrlName($data['user']->id, $story);

        //sorting must be forced due to uuid which has no intrinsic sorting in collection
        $data['storyDetails'] = $data['story']->storyDetails->sortBy('story_counter');

        //getting if user is subscriber of certain story
        if(Auth::check()) {

            $data['userSubscribed'] = UserSubscriptions
                ::isSubscriptionSet($data['user']->id, Auth::user()->id);
        } else {

            $data['userSubscribed'] = null;
        }

        //adding view counter
        $data['story']->addViewCounterPlusOne();

        return view('stories.story', $data);
    }

    /**
     * PUT new story for authenticated user
     * redirects to story overview {username}/{storyname}
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function putStory(Request $request)
    {
        //getting user
        $user = User::findOrFail(Auth::user()->id);

        //validation: required + unique for every user(id) + no '/' in name
        $request->validate([
            'name'  =>  'required|unique:stories,name,Null,stories,user_id,' . $user->id . '|not_regex:/\//',
        ]);

        $story = new Stories();
        $story->create($request->name, $user);

        return redirect(Route('story', ['username' => $user->url_name, 'story' => $story->url_name]));
    }

    /**
     * PATCH existing story for owner
     * redirects to story details afterwards
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function patchStory(Request $request)
    {
        //getting user
        $user = User::findOrFail(Auth::user()->id);

        //validation: required + unique for every user(id) + no '/' in name
        $request->validate([
            'name'              =>  'required|unique:stories,name,Null,stories,user_id,' . $user->id . '|not_regex:/\//',
            'story_to_be_updated'  => 'required|uuid',
        ]);

        //getting story
        $story = Stories::findOrFail($request->story_to_be_updated);

        //if user is not owner
        if($story->user_id !== $user->id) {

            return redirect(Route('home'), 403);
        }

        //updating story
        $story->updateStory($request->name, $user);

        //redirecting back to story
        return redirect(Route('story', ['username' => $user->url_name, 'story' => $story->url_name]));
    }

    /**
     * DELETE existing story for owner
     * redirects to stories afterwards
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteStory(Request $request)
    {
        //validation: required + unique for every user(id) + no '/' in name
        $request->validate([
            'story_to_be_deleted'  => 'required|uuid',
        ]);

        //getting user
        $user = User::findOrFail(Auth::user()->id);

        //getting story
        $story = Stories::findOrFail($request->story_to_be_deleted);

        //if user is not owner
        if($story->user_id !== $user->id) {

            return redirect(Route('home'), 403);
        }

        //updating story
        $story->deleteStory();

        //redirecting back to stories
        return redirect(Route('stories', ['username' => $user->url_name]));
    }

    /**
     * Renders story detail view {username}/{story}/{count}
     *
     * @param $username
     * @param $story
     * @param $storyCounter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storyDetail($username, $story, $storyCounter)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);
        $data['story'] = Stories::getStoryByUrlName($data['user']->id, $story);
        //sorting must be forced due to uuid which has no intrinsic sorting in collection
        $data['storyDetail'] = StoryDetails::getStoryDetailsByStoryIdAndCounter($data['story']->id,$storyCounter);

        //adding view counter
        $data['storyDetail']->addViewCounterPlusOne();

        return view('stories.story-details', $data);
    }

    /**
     * PUT new story detail and attaches it to given story
     * redirects to detail afterwards
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \thimstory\Exceptions\NotYetAllowedToCreateException
     */
    public function putStoryDetails(Request $request)
    {
        //validate im is image and max size
        $request->validate([
            'story_detail'   => 'required|image|mimes:jpeg,png,jpg,gif,svg', //todo: check for size
            'story_id'      => 'required|uuid'
        ]);

        //getting user
        $user = User::findOrFail(Auth::user()->id);

        //getting story
        $story = Stories::findOrFail($request->story_id);

        //if user is not owner
        if($story->user_id !== $user->id) {

            return redirect(Route('home'), 403);
        }

        $storyDetail = new StoryDetails();
        $storyDetail->create($story, $request->story_detail->getClientMimeType());

        $request->story_detail->move(public_path('storyDetails'), $storyDetail->id); //todo: must be changed to external storage (S3?)

        return response()->json([
            'status'    => 'success',
            'message'   => Lang::get('content.status_messages.success_storyDetail'),
            'route'     => route('storyDetail', [
                $user->getName(),
                $story->name,
                $storyDetail->story_counter
            ]),
        ]);
    }

    /**
     * PATCH story details via overwriting image in storage + updating mime type
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function patchStoryDetails(Request $request)
    {
        //validate im is image and max size
        $request->validate([
            'story_detail'   => 'required|image|mimes:jpeg,png,jpg,gif,svg', //todo: check for size
            'story_detail_id' => 'required|uuid',
        ]);

        //getting user
        $user = User::findOrFail(Auth::user()->id);

        //getting story detail
        $storyDetail = StoryDetails::findOrFail($request->story_detail_id);

        //getting story
        $story = Stories::findOrFail($storyDetail->stories_id);

        //if user is not owner
        if($storyDetail->stories->user_id !== $user->id) {
            return redirect(Route('home'), 403);
        }

        //update mime type
        $storyDetail->updateStoryDetails($request->story_detail->getClientMimeType());

        //update (overwrite) image
        $request->story_detail->move(public_path('storyDetails'), $storyDetail->id); //todo: must be changed to external storage (S3?)

        return redirect(Route('storyDetail', [
            'username' => $user->name,
            'story' => $story->name,
            'storyCounter' => $storyDetail->story_counter,
        ]));
    }

    /**
     * DELETE story details with removing of images and soft delete of db entry
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteStoryDetails(Request $request)
    {
        //validate im is image and max size
        $request->validate([
            'story_detail_to_be_deleted' => 'required|uuid',
        ]);

        //getting user
        $user = User::findOrFail(Auth::user()->id);

        //getting story detail
        $storyDetail = StoryDetails::findOrFail($request->story_detail_to_be_deleted);

        //if user is not owner
        if($storyDetail->stories->user_id !== $user->id) {

            return redirect(Route('home'), 403);
        }

        //getting story
        $story = Stories::findOrFail($storyDetail->stories_id);

        File::delete('storyDetails/' . $storyDetail->id);
        $storyDetail->deleteStoryDetails();

        //redirecting back to story
        return redirect(Route('story', ['username' => $user->url_name, 'story' => $story->url_name]));
    }
}
