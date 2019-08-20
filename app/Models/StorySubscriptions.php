<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

/**
 * Stories can be subscribed
 * Class Subscriptions
 * @package thimstory\Models
 */
class StorySubscriptions extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story_id',
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
     * Describes user which subscribed to this story
     *
     * @return Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\thimstory\Models\User');
    }

    /**
     * Describes story to which use has subscribed
     *
     * @return Eloquent\Relations\BelongsTo
     */
    public function stories()
    {
        return $this->belongsTo('\thimstory\Models\Stories');
    }

    /**
     * Returns existing subscription if exists
     *
     * @param $storyId
     * @param $userId
     * @return mixed
     */
    public static function isSubscriptionSet($storyId, $userId)
    {
        $isSubscriptionSet = StorySubscriptions::where('stories_id', $storyId)
            ->where('user_id', $userId)
            ->first();

        return $isSubscriptionSet;
    }

    public function subscribe($storyId, $userId)
    {
        $this->stories_id = $storyId;
        $this->user_id = $userId;

        return $this->save();
    }

    public function unsubscribe()
    {
        return $this->delete();
    }
}
