<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

class UserSubscriptions extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscribed_user_id',
        'user_id',
        'update',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'update'            => 'boolean',
    ];

    /**
     * Describes user which subscribed to another one

     * @return Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\thimstory\Models\User');
    }

    /**
     * Describes user to which has been subscribed
     *
     * @return Eloquent\Relations\BelongsTo
     */
    public function subscribedUser()
    {
        return $this->belongsTo('\thimstory\Models\User', 'subscribed_user_id', 'id');
    }

    /**
     * Returns existing subscription if exists
     *
     * @param $subscribedUserId
     * @param $userId
     * @return mixed
     */
    public static function isSubscriptionSet($subscribedUserId, $userId)
    {
        $isSubscriptionSet = UserSubscriptions::where('subscribed_user_id', $subscribedUserId)
            ->where('user_id', $userId)
            ->first();

        return $isSubscriptionSet;
    }

    /**
     * Subscribing defined user where $subscribedUserId is the one being subscribed to by $userId
     *
     * @param $subscribedUserId
     * @param $userId
     * @return bool
     */
    public function subscribe($subscribedUserId, $userId)
    {
        $this->subscribed_user_id = $subscribedUserId;
        $this->user_id = $userId;

        return $this->save();
    }

    /**
     * Deleting of subscription from DB
     *
     * @return bool|null
     * @throws \Exception
     */
    public function unsubscribe()
    {
        return $this->delete();
    }
}
