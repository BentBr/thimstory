<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Str;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;
use thimstory\Models\StorySubscriptions;
use thimstory\Models\UserSubscriptions;

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
        'email_verified_at' => 'datetime',
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
    public function storySubscriptions()
    {
        return $this->HasMany('\thimstory\Models\StorySubscriptions');
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
     * finds user by remember_token in table users
     *
     * @param $token
     * @return mixed
     */
    public static function getUserByToken($token)
    {
        return User::where('remember_token', $token)
                ->firstOrFail();
    }

    /**
     * Generates new remember token for login / deletion
     *
     * @return bool
     */
    public function generateToken()
    {
        $this->remember_token = Str::random(100);

        return $this->update([
            'remember_token'    => $this->remember_token,
        ]);
    }

    /**
     * Deletes token of current user. preferably after successfully login
     *
     * @return bool
     */
    public function deleteToken()
    {
        return $this->forceFill([
            'remember_token'    => null,
        ])->save();
    }

    /**
     * verifies email address of current user by setting timestamp = now
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
     *
     * @param $email
     * @return bool
     */
    public function createUserWithEmail($email)
    {
        //create new user
        $this->email = $email;
        $this->name = $email;
        $this->url_name = rawurlencode($email);

        return $this->save();
    }


    /**
     * Updates user in DB according to given user's object
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
     * Deletes user (softdelete)
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
        $subscriptions['storySubscriptions'] = StorySubscriptions::where('user_id', $this->id)
            ->get();
        $subscriptions['userSubscriptions'] = UserSubscriptions::where('user_id', $this->id)
            ->get();

        //checking if present
        if(count($subscriptions['storySubscriptions']) == 0 && count($subscriptions['userSubscriptions']) == 0) {

            return null;
        }
        return $subscriptions;
    }
}
