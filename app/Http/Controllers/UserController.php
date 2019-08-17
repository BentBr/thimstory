<?php

namespace thimstory\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use thimstory\Events\UserLogin;
use thimstory\Events\UserRegister;
use thimstory\Models\User;
use Illuminate\Http\Request;
use Exception;
use Lang;
use Str;

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

    //shows profile view of requested user
    public function login()
    {
        return view('users.login');
    }

    //shows profile view of requested user
    public function putLogin(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
        ]);

        //check if user exists
        try {
            $user = User::getUserByEmail($request->email);

            //set new token for login
            $user->remember_token   = Str::random(100);
            $user->save();

            //send login mail
            event(new UserLogin($user));

            //setup hint
            $data['hint'] = Lang::get('auth.login-mail-sent');
        } catch (Exception $exception) {

            //register + login mail
            if ($exception instanceof ModelNotFoundException) {

                $user           = new User;
                $user->email    = $request->email;
                $user->name     = $request->email;
                $user->url_name = rawurlencode($request->email);
                $user->password = Str::random(10);
                $user->remember_token   = Str::random(100);
                $user->save();

                //send register mail
                event(new UserRegister($user));

                //setup hint
                $data['hint'] = Lang::get('auth.register-mail-sent');
            }
        }


        return view('users.login', $data);
    }
}
