<?php

namespace thimstory\Http\Controllers;

use thimstory\Models\User;

class UserController extends Controller
{
    //shows profile view of requested user
    public function profile($username)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);
        $data['stories'] = $data['user']->stories;
        $data['subscriptions'] = $data['user']->subscriptions;

        return view('users.profile', $data);
    }
}
