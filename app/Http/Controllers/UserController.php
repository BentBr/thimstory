<?php

namespace thimstory\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use thimstory\Events\UserLogin;
use thimstory\Events\UserRegister;
use thimstory\Events\UserDelete;
use thimstory\Models\UserSubscriptions;
use thimstory\Models\User;
use Illuminate\Http\Request;
use Exception;
use Lang;

class UserController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Shows profile view of user which is being fetched depending on {username} in url
     *
     * @param $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($username)
    {
        //getting requested data
        $data['user'] = User::getUserByUsername($username);
        $data['stories'] = $data['user']->stories;
        $data['subscriptions'] = $data['user']->getAllUserSubscriptions();

        //getting if auth user is subscriber of certain user
        if(Auth::check()) {

            $data['userSubscribed'] = UserSubscriptions
                ::isSubscriptionSet($data['user']->id, Auth::user()->id);
        } else {

            $data['userSubscribed'] = null;
        }

        return view('users.profile', $data);
    }

    /**
     * shows profile view of requested user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     *      send mail to provided address
     *      If user does not exist -> creates new user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function putLogin(Request $request)
    {

        $request->validate([
            'email'         => 'email|required',
            'axiosLogin'   => 'required',
        ]);

        //check if user exists and sent login mail
        try {
            $user = User::getUserByEmail($request->email);

            //set new token for login
            $user->generateLoginToken();

            //send login mail
            event(new UserLogin($user));

            //setup hint for Frontend
            $data['hint'] = Lang::get('auth.login.login-mail-sent');
        } catch (Exception $exception) {

            //revalidate for uniqueness
            $request->validate([
                'email' => 'unique:users,email|unique:users,name',
            ]);

            //register + login mail
            if ($exception instanceof ModelNotFoundException) {

                //creating new user based on email
                $user           = new User;
                $user->createUserWithEmail($request->email);
                $user->generateLoginToken();

                //send register mail
                event(new UserRegister($user));

                //setup hint
                $data['hint'] = Lang::get('auth.login.register-mail-sent');
            }
        }
        //making sure on axios usage only json is being responded
        if($request->axiosLogin === true) {

            return response()->json([
                'status'    => 'success',
                'message'   =>  $data['hint']
            ]);
        }

        return view('users.login', $data);
    }

    /**
     * Login with login token /login/{token}
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userLoginWithToken($token)
    {
        //find user via token
        $user = User::getUserByLoginToken($token);

        //login user
        $this->guard()->login($user, true);

        //delete token
        $user->deleteLoginToken();

        //verify email address if not yet done
        if(is_null($user->email_verified_at)) {

            $user->verifyEmail();
        }

        return redirect('/'. $user->url_name . '/stories');
    }

    /**
     * Users Logout
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        //logout user
        $this->guard()->logout();

        return redirect(Route('home'));
    }

    /**
     * PATCH receives updated user data and stores it.
     * Redirects to new users "home" aka profile
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function patchUser(Request $request)
    {
        //validate if email is a valid email.
        //checkes if username und email are unique spanning email and name columns
        //checks if username has no '/'
        $request->validate([
            'name'      => 'required|unique:users,email|unique:users,name|not_regex:/\//',
            'email'     => 'required|email|unique:users,email|unique:users,name',
        ]);

        $user       = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email= $request->email;
        $user->updateUser();

        return redirect(Route('profile', ['username' => $user->url_name]));
    }

    /**
     * DELETE marks user as deleted and redirects to home afterwards
     * Verfies with token
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteUser($token)
    {
        //find user via token
        $user = User::getUserByLoginToken($token);

        //delete user
        $user->deleteUser();

        //delete token
        $user->deleteLoginToken();

        return redirect(Route('home'));
    }

    /**
     * DELETE marks user as deleted and redirects to home afterwards
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendDeleteVerificationMail()
    {
        $user       = User::findOrFail(Auth::user()->id);
        $user->generateLoginToken();

        //fire event for sending deletion mail
        event(new UserDelete($user));

        return redirect(Route('profile', ['username' => $user->url_name]));
    }
}
