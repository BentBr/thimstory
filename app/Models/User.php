<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;
use thimstory\Models\UserSubscriptions;
use thimstory\Models\Stories;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url_name',
        'email',
        'password',
        'new_story_possible_at',
        'new_story_detail_possible_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at'             => 'datetime',
        'new_story_possible_at'         => 'datetime',
        'new_story_detail_possible_at'  => 'datetime',
    ];

    /**
     * @return Eloquent\Relations\HasMany
     */
    public function stories()
    {
        return $this->HasMany('\thimstory\Models\Stories');
    }

    /**
     * @return Eloquent\Relations\HasMany
     */
    public function userSubscriptions()
    {
        return $this->HasMany('\thimstory\Models\UserSubscriptions', 'subscribed_user_id');
    }

    /**
     * finds user by name in table users
     *
     * @param $userName
     * @return mixed
     */
    public static function getUserByUsername($userName)
    {
        return User::where('name', $userName)
                ->firstOrFail();
    }

    /**
     * finds user by email in table users
     *
     * @param $userEmail
     * @return mixed
     */
    public static function getUserByEmail($userEmail)
    {
        return User::where('email', $userEmail)
                ->firstOrFail();
    }

    /**
     * Finds user by user id. Checks for login_token of user in given token
     * accepts base64 token with id: and token: (json)
     *
     * @param $token
     * @return mixed
     */
    public static function getUserByLoginTokenBase64($token)
    {
        $tokenArray = json_decode(base64_decode($token));
        $id = $tokenArray->id;
        $token = $tokenArray->token;

        $user = User::findOrFail($id);
        if ($user->checkLoginToken($token)){

            return $user;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Returns if given token is correct for current user
     *
     * @param $token
     * @return bool
     */
    public function checkLoginToken($token)
    {
        return $this->login_token == $token;
    }

    /**
     * Generates new remember token for login / deletion
     * true if successful, false if not
     *
     * @return bool
     */
    public function generateLoginToken()
    {
        $this->login_token = Str::random(100);

        return $this->update([
            'login_token'    => $this->login_token,
        ]);
    }

    /**
     * Deletes token of current user. preferably after successfully login
     * true if successful, false if not
     *
     * @return bool
     */
    public function deleteLoginToken()
    {
        return $this->forceFill([
            'login_token'    => null,
        ])->save();
    }

    /**
     * verifies email address of current user by setting timestamp = now
     * true if successful, false if not
     *
     * @return bool
     */
    public function verifyEmail()
    {
        return $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    /**
     * Creates user with provided email address
     * true if successful, false if not
     *
     * @param $email
     * @return bool
     */
    public function createUserWithEmail($email)
    {
        //create new user
        $this->email                        = $email;
        $this->name                         = $email;
        $this->url_name                     = rawurlencode($email);
        $this->new_story_possible_at        = now();
        $this->new_story_detail_possible_at = now();

        return $this->save();
    }


    /**
     * Updates user in DB according to given user's object
     * true if successful, false if not
     *
     * @return bool
     */
    public function updateUser()
    {
       return $this->update([
           'name'       => $this->name,
           'email'      => $this->email,
           'url_name'   => rawurlencode($this->name),
        ]);
    }

    /**
     * Deletes user (soft delete)
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteUser()
    {
        return $this->delete();
    }

    /**
     * Returns users with most views decr paginated by $pagination
     *
     * @param int $pagination
     * @return mixed
     */
    public static function getUsersBasedOnViews(int $pagination)
    {
        $users = User::orderBy('views', 'desc')
                ->paginate($pagination);

        return $users;
    }

    /**
     * Collects oll subs of a user and returns 2 dim array
     *
     * @return Collection
     */
    public function getAllUserSubscriptions()
    {
        //getting subs
        $subscriptions['userSubscriptions'] = UserSubscriptions::where('user_id', $this->id)
            ->get();

        //checking if present
        if(count($subscriptions['userSubscriptions']) == 0) {

            return null;
        }
        return $subscriptions;
    }

    /**
     * Gives datetime on which user can add another story
     * Returns null if is in past
     *
     * @return null|Carbon
     */
    public function getDateForNextStory()
    {
        if (Carbon::now() > $this->new_story_possible_at) {

            return null;
        } else {

            return $this->new_story_possible_at->diffForHumans();
        }
    }

    /**
     * Gives datetime on which user can add another story detail
     * Returns null if is in past
     *
     * @return null|Carbon
     */
    public function getDateForNextStoryDetail()
    {
        if (Carbon::now() > $this->new_story_detail_possible_at) {

            return null;
        } else {

            return $this->new_story_detail_possible_at->diffForHumans();
        }
    }

    /** Returns all user's stories with latest on top
     *
     * @return Eloquent\Relations\HasMany
     */
    public function getAllUsersStoriesSorted()
    {
        $stories = $this->stories()->get();

        !is_null($stories) ?  $stories->sortBy('updated_at') : null;

        return $stories;
    }

    /**
     * The avatar being saved on gravater
     * removed set support: &set=set1
     *
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return "https://robohash.org/" . md5($this->email) . "?gravatar=hashed";
    }

    /**
     * Returning a json string encoded to base64 with user id and login_token
     *
     * @return string
     */
    public function getUserIdAndLoginTokenBase64()
    {
        $data = [
            'id'        => $this->id,
            'token'     => $this->login_token
        ];
        return base64_encode(json_encode($data));
    }

    /**
     * returns username in URL encoded version from database
     *
     * @return mixed
     */
    public function getUrlName()
    {
        return $this->url_name;
    }

    /**
     * returns username ifrom database
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
