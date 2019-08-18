<?php

namespace thimstory\Http\Controllers;

use thimstory\Models\User;
use thimstory\Models\Stories;
use Auth;
use Illuminate\Http\Request;

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
        $data['stories'] = $data['user']->stories;

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
        $data['storyDetails'] = $data['story']->storyDetails;

        return view('stories.story', $data);
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
        $data['storyDetail'] = $data['story']->storyDetails;

        return view('stories.story-details', $data);
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
        $user = User::findOrFail( Auth::user()->id);

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
        $user = User::findOrFail( Auth::user()->id);

        //validation: required + unique for every user(id) + no '/' in name
        $request->validate([
            'name'              =>  'required|unique:stories,name,Null,stories,user_id,' . $user->id . '|not_regex:/\//',
            'storyToBeUpdated'  => 'required|uuid',
        ]);

        //getting story
        $story = Stories::findOrFail($request->storyToBeUpdated);

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
        //getting user
        $user = User::findOrFail( Auth::user()->id);
        //validation: required + unique for every user(id) + no '/' in name
        $request->validate([
            'storyToBeDeleted'  => 'required|uuid',
        ]);

        //getting story
        $story = Stories::findOrFail($request->storyToBeDeleted);

        //if user is not owner
        if($story->user_id !== $user->id) {

            return redirect(Route('home'), 403);
        }

        //updating story
        $story->deleteStory();

        //redirecting back to stories
        return redirect(Route('stories', ['username' => $user->url_name]));
    }
}
