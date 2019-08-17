<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

class Stories extends Model
{
    use SoftDeletes;
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'name',
        'url_name',
        'views',
        'follower',
    ];

    /**
     * @return Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\thimstory\Models\User');
    }

    /**
     * @return Eloquent\Relations\HasMany
     */
    public function storyDetails()
    {
        return $this->HasMany('\thimstory\Models\StoryDetails');
    }

    /**
     * @return Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->HasMany('\thimstory\Models\Subscriptions');
    }

    public static function getStoryByUrlName($userId, $story)
    {
        return Stories::where('user_id', $userId)
            ->where('name', $story)
            ->firstOrFail();
    }
}
