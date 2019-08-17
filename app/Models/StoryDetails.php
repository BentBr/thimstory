<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
use thimstory\Models\Concerns\UsesUuid;

class StoryDetails extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story_counter',
        'story_id,'
    ];


    /**
     * @return Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\thimstory\Models\User');
    }

    /**
     * @return Eloquent\Relations\BelongsTo
     */
    public function stories()
    {
        return $this->belongsTo('\thimstory\Models\Stories');
    }

    public static function getStoryDetailsByStoryIdAndCounter($story, $storyCounter)
    {
        return StoryDetails::where('stories_id', $story)
            ->where('story_counter', $storyCounter)
            ->firstOrFail();
    }
}
