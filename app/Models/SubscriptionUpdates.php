<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

class SubscriptionUpdates extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'update_user_id',
        'type',
    ];

    /**
     * Describes user which has updated (owner of story)
     *
     * @return Eloquent\Relations\BelongsTo
     */
    public function updatedUser()
    {
        return $this->belongsTo('\thimstory\Models\User', 'update_user_id', 'id');
    }

    /**
     * Describes which story has been updated
     *
     * @return Eloquent\Relations\HasOne
     */
    public function updatedStory()
    {
        return $this->hasOne('\thimstory\Models\Stories', 'updated_story', 'id');
    }
}
