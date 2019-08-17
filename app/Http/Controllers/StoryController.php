<?php

namespace thimstory\Http\Controllers;

use thimstory\Models\StoryDetails;
use thimstory\Models\User;
use thimstory\Models\Stories;

class StoryController extends Controller
{
    //shows stories view of requested user
    public function stories($username)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);
        $data['stories'] = $data['user']->stories;

        return view('stories.stories', $data);
    }

    //shows details view of requested story
    public function story($username, $story)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);
        $data['story'] = Stories::getStoryByUrlName($data['user']->id, $story);
        $data['storyDetails'] = $data['story']->storyDetails;

        return view('stories.story', $data);
    }

    //shows details view of requested story
    public function storyDetail($username, $story, $storyCounter)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);
        $data['story'] = Stories::getStoryByUrlName($data['user']->id, $story);
        $data['storyDetail'] = $data['story']->storyDetails;

        return view('stories.story-details', $data);
    }
}
